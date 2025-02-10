<?php

namespace App\Livewire;
use App\Mail\ResponseEmail;
use App\Models\Users;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSubmission; // Import your model
use App\Models\Survey2Response; // Import your response model
use App\Models\SurveyToken;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Survey2 extends Component
{
    public $responses = [];
    public $additionalComment;
    public $submissionDetails;
    public $token;

    public function mount($token = null)
    {
        
        $this->token = $token;
        $this->responses = array_fill(1, 9,'Na'); 

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $surveyToken = SurveyToken::where('token', $token)->first();
            
            if (!$surveyToken || $surveyToken->used) {
                session()->flash('error', 'Invalid or expired token.');
                return redirect('/survey/failed');
            }
            

            $this->submissionDetails = UserSubmission::find($decoded->user_submission_id);

            if (!$this->submissionDetails) {
                session()->flash('error', 'No submission found for this token.');
                return redirect('/survey/failed');
            }
            
        } catch (\Exception $e) {
            session()->flash('error', 'Invalid token.');
            
            return redirect('/survey/failed');
        }
    }


    public function submit()
    {
       

        // Validate responses to ensure each question has been answered
        
       
        $decoded = JWT::decode($this->token, new Key(env('JWT_SECRET'), 'HS256'));
        
        // Check if the user has already submitted the survey
        $userSubmission = UserSubmission::where('client_id', $decoded->client_id)
                            ->first();

         // Calculate Promoters, Detractors, and Neutrals
        $promoters = collect($this->responses)->filter(function ($score) {
            return $score >= 9 && $score <= 10;
        })->count();

        $detractors = collect($this->responses)->filter(function ($score) {
            return $score >= 0 && $score <= 6;
        })->count();

        $neutrals = collect($this->responses)->filter(function ($score) {
            return $score >= 7 && $score <= 8;
        })->count();

        $totalRespondents = $promoters + $neutrals + $detractors;

        if ($totalRespondents > 0) {
            $promoterPercentage = round(($promoters / $totalRespondents) * 100, 2);
            $detractorPercentage = round(($detractors / $totalRespondents) * 100, 2);
            $neutralPercentage = round(($neutrals / $totalRespondents) * 100, 2);
            $nps = $promoterPercentage - $detractorPercentage;
        } else {
            $promoterPercentage = 0;
            $detractorPercentage = 0;
            $neutralPercentage = 0;
            $nps = null; // No responses, NPS cannot be calculated
        }
        
        Survey2Response::updateOrCreate(
            ['client_id' => $userSubmission->client_id],
            [
                'Q1' => $this->responses[1] ?? null,
                'Q2' => $this->responses[2] ?? null,
                'Q3' => $this->responses[3] ?? null,
                'Q4' => $this->responses[4] ?? null,
                'Q5' => $this->responses[5] ?? null,
                'Q6' => $this->responses[6] ?? null,
                'Q7' => $this->responses[7] ?? null,
                'Q8' => $this->responses[8] ?? null,
                'Q9' => $this->responses[9] ?? null,
                'additional_comments' => $this->additionalComment ?? 'No additional comments.',
                'Promoter' => $promoters,
                'Detractor' => $detractors,
                'Neutral' => $neutrals,
                'Promoter_percentage' => $promoterPercentage,
                'Detractor_percentage' => $detractorPercentage,
                'Neutral_percentage' => $neutralPercentage,
                'Nps_percentage' => $nps,
            ]
        );
        
       
        

         // Prepare data for the email
         $surveyData = [
            'nps' => $nps , // You can calculate NPS based on responses
            'project_name' => $userSubmission->projectName,
            'ids_lead' => $userSubmission->idsLeadManager,
            'client_organization' => $userSubmission->clientOrganization,
            'client_contact_name' => $userSubmission->clientContactName,
            'email_sent_date' => now()->format('Y-m-d'),
            'survey_date' => $userSubmission->created_at->format('Y-m-d'),
            'response_1' => $this->responses[1],
            'response_2' => $this->responses[2],
            'response_3' => $this->responses[3],
            'response_4' => $this->responses[4], 
            'response_5' => $this->responses[5],
            'response_6' => $this->responses[6],
            'response_7' => $this->responses[7],
            'response_8' => $this->responses[8],
            'response_9' => $this->responses[9],
            'additional_comments' => $this->additionalComment ?? 'No additional comments.', // Replace this with actual comment if available
        ];

        // Mark the token as used after submission
        $surveyToken = SurveyToken::where('token', $this->token)->first();
        $surveyToken->used = true;
        $surveyToken->save();
        
        // Update user submission status to 'done'
        $userSubmission->status = 'Done';
        $userSubmission->save();
        
        session()->flash('message', 'Survey responses have been saved.');
        $userEmail = Users::where('id', $userSubmission->user_id)->first();
        
         // Send email
        Mail::to($userEmail->email)->send(new ResponseEmail($surveyData));
        
        return redirect('/survey/success');
        
    }
    public function render()
    {
        return view('livewire.survey2')->layout('components.layouts.app-default');
    }
}