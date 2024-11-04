<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class Sidebar extends Component
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
    public function logout()
    {
        
        // Logout the authenticated user, regardless of their role
        Auth::logout();

        // Regenerate the session to avoid session fixation attacks
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login'); // Redirect to the login page after logout
    }
    public function render()
    {
        return view('livewire.sidebar');
    }
}
