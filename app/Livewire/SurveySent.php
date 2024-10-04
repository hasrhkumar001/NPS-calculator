<?php

namespace App\Livewire;

use Livewire\Component;

class SurveySent extends Component
{
    public $email;
    public function mount($email)
    {
        $this->email = $email;
    }
    public function goBackToSurvey()
    {
        return $this->redirect('/survey',navigate:true);
    }
    public function render()
    {
        return view('livewire.survey-sent');
    }
}
