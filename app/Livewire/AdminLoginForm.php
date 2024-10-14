<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminLoginForm extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];
    public function mount()
    {
        // Check if the admin is already authenticated
        if (Auth::guard('admin')->check()) {
            // Redirect to the admin dashboard if logged in
            return redirect('/admin/dashboard');  // Change this to the appropriate admin dashboard route
        }
    }

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
        return redirect('/admin/dashboard'); // Redirect to admin dashboard
    }


    // If login fails, flash an error message
    session()->flash('error', 'Invalid credentials');
    return back(); // Redirect back to the login page
    }
    public function render()
    {
        return view('livewire.admin-login-form')->layout('components.layouts.app-default');
    }
}
