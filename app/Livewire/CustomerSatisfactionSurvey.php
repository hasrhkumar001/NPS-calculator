<?php

namespace App\Livewire;

use App\Models\UserSubmission;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurveyEmail;
use Illuminate\Support\Facades\Log;
use App\Models\IdsGroup;


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
        $this->idsGroups = IdsGroup::all();
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

         // Check if the user has already submitted the form
        $existingSubmission = UserSubmission::where('user_id', auth()->id())->first();

        if ($existingSubmission) {
            // If the user already submitted, show an error message
            session()->flash('error', 'You have already submitted the form.');
            return;
        }
        
        Mail::to($this->clientEmailAddress)->send(new SurveyEmail($this->clientContactName, $this->idsLeadManager));

        // Store the form data in the database
        UserSubmission::create([
            'user_id' => auth()->id(),
            'idsGroup' => $this->idsGroup,
            'projectName' => $this->projectName,
            'csatOccurrence' => $this->csatOccurrence,
            'idsLeadManager' => $this->idsLeadManager,
            'clientOrganization' => $this->clientOrganization,
            'clientContactName' => $this->clientContactName,
            'clientEmailAddress' => $this->clientEmailAddress,
        ]);
       

        // You can add a success message or redirect
        session()->flash('message', 'Survey email has been sent to the client.');
    }
    public function render()
    {
        return view('livewire.customer-satisfaction-survey');
    }
}
