<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Users;
use App\Models\IdsGroup; // Assuming this is the model for IDS groups
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EditUser extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password;
    public $idsGroup;
    public $idsGroups; // To store available IDS groups

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'sometimes|nullable|min:6',
        'idsGroup' => 'required|string', // Ensure this field is validated
    ];

    public function mount($userId)
    {
        $this->userId = $userId;
        $user = Users::findOrFail($userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->idsGroup = $user->idsGroup; // Fetch the current IDS group of the user
        $this->idsGroups = IdsGroup::all(); // Fetch all available IDS groups
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
        $user->idsGroup = $this->idsGroup; // Save the selected IDS group

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        session()->flash('message', 'User updated successfully.');
        
        $this->reset(['password']);
    }

    public function render()
    {
        return view('livewire.edit-user', [
            'idsGroups' => $this->idsGroups, // Pass the groups to the view
        ]);
    }
}
