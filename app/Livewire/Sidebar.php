<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class Sidebar extends Component
{
    public $role ;
    public function mount()
    {
        
        if (Auth::guard('admin')->check()) {
            $this->role = 'admin';
            
        } elseif (AutH::guard('web')->check()) {
            $this->role = 'user';
        }
        elseif (Auth::guard('subadmin')->check()) {
            $this->role = 'subadmin';
        } else {
            $this->role = null; // Not authenticated
        }
    }
    public function render()
    {
        return view('livewire.sidebar');
    }
}
