<?php

namespace App\Livewire;

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
        $admin = Admin::findOrFail($adminId);
        $this->name = $admin->name;
        $this->email = $admin->email;
      
    }

    public function updateAdmin()
    {
        $this->rules['email'] = [
            'required',
            'email',
            'max:255',
            Rule::unique('admins')->ignore($this->adminId),
        ];

        $this->validate();

        $admin = Admin::findOrFail($this->adminId);
        $admin->name = $this->name;
        $admin->email = $this->email;
        $admin->password = Hash::make($this->password);
      

        $admin->save();

        session()->flash('message', 'Admin updated successfully.');
        
        $this->reset(['password']);
    }
    public function render()
    {
        return view('livewire.edit-admin');
    }
}
