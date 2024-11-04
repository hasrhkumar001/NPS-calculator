<?php

namespace App\Livewire;

use App\Models\Users;
use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EditAdmin extends Component
{
    public $adminId;
    public $name;
    public $email;
    public $password;
    
    

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'sometimes|nullable|min:6',
        
    ];

    public function mount($adminId)
    {
        $this->adminId = $adminId;
        $admin = Users::findOrFail($adminId);
        $this->name = $admin->name;
        $this->email = $admin->email;
      
    }

    public function updateAdmin()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->adminId), // Validate unique email in 'users' table
            ],
            'password' => 'sometimes|nullable|min:6', // Password is optional and validated only if provided
        ]);

        $admin = Users::findOrFail($this->adminId);
        $admin->name = $this->name;
        $admin->email = $this->email;

        // Only update the password if one is provided
        if (!empty($this->password)) {
            $admin->password = Hash::make($this->password);
        }

        $admin->save();
        
        session()->flash('message', 'Admin updated successfully.');
        
        $this->reset(['password']);
    }
    public function render()
    {
        return view('livewire.edit-admin');
    }
}
