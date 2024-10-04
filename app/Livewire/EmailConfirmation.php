<?php

namespace App\Livewire;

use Livewire\Component;

class EmailConfirmation extends Component
{
    public $client;

    public function mount($client)
    {
        $this->client = $client;
    }
    public function render()
    {
        return view('livewire.email-confirmation')->layout('components.layouts.app-default');
    }
}
