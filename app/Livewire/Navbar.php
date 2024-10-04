<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public $role ;

    
    public function mount()
    {
        
        if (Auth::guard('admin')->check()) {
            $this->role = 'admin';
            
        } elseif (Auth::guard('web')->check()) {
            $this->role = 'user';
        }elseif (Auth::guard('subadmin')->check()) {
            $this->role = 'subadmin';
        }else {
            $this->role = null; // Not authenticated
        }
    }
    public function logout()
    {
        if ($this->role === 'admin') {
            Auth::guard('admin')->logout(); // Admin logout
        } else {
            Auth::guard('web')->logout(); // User logout
        }
        return redirect('/login'); // Redirect to the login page after logout
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
