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

    public function login(Request $request)
    {
       // Validate the request data
    $validated = $this->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Attempt to login as admin
    if (Auth::guard('admin')->attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard'); // Redirect to admin dashboard
    }

    // Attempt to login as a regular user
    if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard'); // Redirect to the regular user dashboard
    }

    // If login fails, flash an error message
    session()->flash('error', 'Invalid credentials');
    return back(); // Redirect back to the login page
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}