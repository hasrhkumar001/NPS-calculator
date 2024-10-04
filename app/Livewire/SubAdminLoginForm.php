<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SubAdminLoginForm extends Component
{
    
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login(Request $request)
    {
       // Validate the request data
    $validated = $this->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

   
    // Attempt to login as subadmin
    if (Auth::guard('subadmin')->attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
        $request->session()->regenerate();
        return redirect('/subadmin/dashboard'); // Redirect to subadmin dashboard
    }


    // If login fails, flash an error message
    session()->flash('error', 'Invalid credentials');
    return back(); // Redirect back to the login page
    }

    public function render()
    {
        return view('livewire.sub-admin-login-form')->layout('components.layouts.app-default');
    }
}
