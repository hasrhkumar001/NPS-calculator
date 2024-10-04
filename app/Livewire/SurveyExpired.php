<?php

namespace App\Livewire;

use Livewire\Component;

class SurveyExpired extends Component
{
    public function render()
    {
        return view('livewire.survey-expired')->layout('components.layouts.app-default');
    }
}
