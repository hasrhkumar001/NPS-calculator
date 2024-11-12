<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public $role ;

    
    public function mount()
    {
        
        if (Auth::check()) {
            // Set the role based on the user's role field
            $user = Auth::user();
            if ($user->role == 3) {
                $this->role = 'admin';
            } elseif ($user->role == 2) {
                $this->role = 'subadmin';
            } elseif ($user->role == 1) {
                $this->role = 'user';
            } else {
                $this->role = null; // Unknown role or not authenticated
            }
        } else {
            $this->role = null; // Not authenticated
        }
    }
  

    public function render()
    {
        return view('livewire.navbar');
    }
}
