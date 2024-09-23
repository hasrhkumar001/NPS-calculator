<?php

namespace App\Livewire;

use Livewire\Component;

class EmailConfirmation extends Component
{
    public $email;

    public function mount($email)
    {
        $this->email = $email;
    }
    public function render()
    {
        return view('livewire.email-confirmation');
    }
}
