<?php

namespace App\Livewire;

use Livewire\Component;

class EmailConfirmation extends Component
{
    public $client;

    // public function mount($client =null)
    // {
    //     if (!$client) {
    //         // Handle the case when the client is missing
    //         abort(404, 'Client not found');
    //         return;
    //     }
    //     $this->client = $client;
    // }
    public function render()
    {
        return view('livewire.email-confirmation')->layout('components.layouts.app-default');
    }
}
