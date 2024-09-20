<?php

namespace App\Livewire;
use App\Mail\ResponseEmail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSubmission; // Import your model
use App\Models\Survey2Response; // Import your response model

class Survey2 extends Component
{
    public $responses = [];
    public $submissionDetails; // Store submission details

    public function mount()
    {
        $userId = Auth::id();
        // Fetch the user's submission details
        $this->submissionDetails = UserSubmission::where('user_id', $userId)->first();

        // Check if the submission exists
        if (!$this->submissionDetails) {
            session()->flash('error', 'No submission found for this user.');
            return redirect()->back();
        }
    }

    public function submit()
    {
        $userId = Auth::id();

        // Validate responses to ensure each question has been answered
        $this->validate([
            
            'responses.1' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,Na',
            'responses.2' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,Na',
            'responses.3' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,Na',
            'responses.4' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,Na',
            'responses.5' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,Na',
            'responses.6' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,Na',
            'responses.7' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,Na',
            'responses.8' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,Na',
            'responses.9' => 'required|in:0,1,2,3,4,5,6,7,8,9,10,Na',
           
           

        ]);

        // Check if the user has already submitted the survey
        $userSubmission = UserSubmission::where('user_id', $userId)->first();
        if (!$userSubmission || $userSubmission->status == 'done') {
            session()->flash('error', 'You have already submitted the survey.');
            return;
        }

        // Save each response
        foreach ($this->responses as $questionIndex => $response) {
            Survey2Response::updateOrCreate(
                [
                    'user_submission_id' => $userSubmission->id,
                    'question_index' => $questionIndex, // Save the index as question ID
                ],
                ['response' => $response]
            );
        }

         // Prepare data for the email
         $surveyData = [
            'nps' => 63, // You can calculate NPS based on responses
            'project_name' => $userSubmission->projectName,
            'ids_lead' => $userSubmission->idsLeadManager,
            'client_organization' => $userSubmission->clientOrganization,
            'client_contact_name' => $userSubmission->clientContactName,
            'email_sent_date' => now()->format('Y-m-d'),
            'survey_date' => $userSubmission->created_at->format('Y-m-d'),
            'quality_of_delivery' => $this->responses[1],
            'quality_of_responses' => $this->responses[2],
            'timeliness_of_responses' => $this->responses[3],
            'it_support' => $this->responses[4], 
            'project_management' => $this->responses[5],
            'latest_tools' => $this->responses[6],
            'value_for_money' => $this->responses[7],
            'overall_support' => $this->responses[8],
            'work_with_us_again' => $this->responses[9],
            'additional_comments' => 'testing', // Replace this with actual comment if available
        ];

         // Send email
         Mail::to($userSubmission->clientEmailAddress)->send(new ResponseEmail($surveyData));

        // Update user submission status to 'done'
        $userSubmission->status = 'done';
        $userSubmission->save();
        
        

       

        session()->flash('message', 'Survey responses have been saved.');
        return redirect()->back();
    }
    public function render()
    {
        return view('livewire.survey2');
    }
}