<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class EditUser extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'sometimes|nullable|min:6',
    ];

    public function mount($userId)
    {
        $this->userId = $userId;
        $user = Users::findOrFail($userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password =$user->password;
    }

    public function updateUser()
    {
        $this->rules['email'] = [
            'required',
            'email',
            'max:255',
            Rule::unique('users')->ignore($this->userId),
        ];

        $this->validate();

        $user = Users::findOrFail($this->userId);
        $user->name = $this->name;
        $user->email = $this->email;
        
        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        session()->flash('message', 'User updated successfully.');
        
        $this->reset(['password', 'password_confirmation']);
    }
    public function render()
    {
        return view('livewire.edit-user');
    }
}
