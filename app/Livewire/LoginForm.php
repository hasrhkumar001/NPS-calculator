<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginForm extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];
  
    public function mount()
    {
        // Redirect if the user is already logged in
        if (Auth::check()) {
            $user = Auth::user();

            // Redirect based on the user's role
            if ($user->role == 1) {
                return redirect()->to('/user'); // Redirect to regular user dashboard
            } elseif ($user->role == 2) {
                return redirect()->to('/subadmin'); // Redirect to subadmin dashboard
            } elseif ($user->role == 3) {
                return redirect()->to('/admin'); // Redirect to admin dashboard
            }
        }
    }

    public function login(Request $request)
    {
       // Validate the request data
    $validated = $this->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

   

    // Attempt to login as a regular user
    if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();
        
        // Redirect based on the user's role
        $user = Auth::user();

        if ($user->role == 1) {
            return redirect('/user'); // Redirect to regular user dashboard
        } elseif ($user->role == 2) {
            return redirect('/subadmin'); // Redirect to subadmin dashboard
        } elseif ($user->role == 3) {
            return redirect('/admin'); // Redirect to admin dashboard
        }
    }

    // If login fails, flash an error message
    session()->flash('error', 'Invalid credentials');
    return back(); // Redirect back to the login page
    }

    public function render()
    {
        
        return view('livewire.login-form')->layout('components.layouts.app-default');
    }
}
