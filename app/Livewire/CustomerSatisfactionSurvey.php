<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Question;
use App\Models\UserSubmission;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurveyEmail;
use Illuminate\Support\Facades\Log;
use App\Models\IdsGroup;
use Firebase\JWT\JWT;
use App\Models\SurveyToken;
use Firebase\JWT\Key;

class CustomerSatisfactionSurvey extends Component
{
    public $idsGroup;
    public $date;
    public $projectName;
    public $csatOccurrence;
    public $idsLeadManager;
    public $clientOrganization;
    public $clientContactName;
    public $clientEmailAddress;
    public $emailContent;
    
    public $idsGroups; // Array to store all IDS groups

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
           
       // Get group IDs where at least one of Q1 to Q9 is not null or empty
        $groupIdsWithQuestions = Question::where(function ($query) {
            for ($i = 1; $i <= 9; $i++) {
                $query->whereNotNull("Q{$i}")->where("Q{$i}", '!=', '');
            }
        })->distinct()->pluck('group_id');
        

        if (auth()->user()->role == '3') {
            // If admin, show only groups that have questions
            $this->idsGroups = IdsGroup::whereIn('id', $groupIdsWithQuestions)->get();
               
            
        } else {
            // For other users, decode their assigned groups and display only those
            $this->idsGroups = json_decode(auth()->user()->idsGroup, true);
            
            $userGroupNames = json_decode(auth()->user()->idsGroup, true);
            if (!is_array($userGroupNames)) {
                $userGroupNames = []; // Ensure it’s an array
            }
            
            $this->idsGroups = IdsGroup::whereIn('id', $groupIdsWithQuestions)
            ->whereIn('name', $userGroupNames)
            ->get();
            
            
            
        }
        $this->emailContent = "Improvement is an ongoing process. In the wake of improving our services to our customers, IDS InfoTech shares Customer Satisfaction Survey on a periodic basis to be filled out by its esteemed Customers.\n\nWe appreciate your time and inputs to help us serve you better.";
    }

    public function submit()
    {
        // Validate form inputs
        $this->validate([
            'idsGroup' => 'required',
            'projectName' => 'required',
            'csatOccurrence' => 'required',
            'idsLeadManager' => 'required',
            'clientOrganization' => 'required',
            'clientContactName' => 'required',
            'clientEmailAddress' => 'required|email',
        ]);

        // dd($this->idsGroup);
        
        
        $client = Client::Create(
            [
                'name' => $this->clientContactName,
                'email' => $this->clientEmailAddress,
                'organization' => $this->clientOrganization,
                'idsGroup' => $this->idsGroup,
                'user_id' => auth()->id() // Nullable if not logged in
            ]
        );

       
        // Store the form data in the database
        $userSubmission =UserSubmission::create([
            'user_id' => auth()->id(),
            'client_id' => $client->id,
            'idsGroup' => $this->idsGroup,
            'projectName' => $this->projectName,
            'csatOccurrence' => $this->csatOccurrence,
            'idsLeadManager' => $this->idsLeadManager,
            'clientOrganization' => $this->clientOrganization,
            'clientContactName' => $this->clientContactName,
            'clientEmailAddress' => $this->clientEmailAddress,
        ]);
        // Generate JWT token
        $token = JWT::encode([
            'user_id' => auth()->id(),
            'client_id' => $client->id,
            'user_submission_id' => $userSubmission->id,
            'exp' => time() + (60 * 60 * 24 * 365) // Token expires in 365 days
        ], env('JWT_SECRET'), 'HS256');

        // $dcodeJWT = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

        // dd($dcodeJWT);

        // Save token to database
        SurveyToken::create([
            'token' => $token,
            'user_submission_id' => $userSubmission->id,
        ]);

        // Include token in email
        Mail::to($this->clientEmailAddress)->send(new SurveyEmail($this->clientContactName, $this->idsLeadManager, $client, $token));
       

        // You can add a success message or redirect
        // session()->flash('message', 'Survey email has been sent to the client.');
        return $this->redirect('/sent/'.$this->clientEmailAddress,navigate:true);
    }
    public function render()
    {
        return view('livewire.customer-satisfaction-survey');
    }
}
