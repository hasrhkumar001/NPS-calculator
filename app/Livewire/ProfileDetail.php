<?php

namespace App\Livewire;



use Livewire\Component;
use App\Models\User;

class ProfileDetail extends Component
{
    public $user; // To hold user details
    public $name;
    public $email;
    public $avatar;
    public $role;
    public $groups;

    public function mount($userId)
    {
        // Fetch user details based on passed user ID
        $this->user = User::find($userId);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        if ($this->user->role == '3') {
            $this->groups = $this->user->idsGroup;
        } else {
            $this->groups = json_decode($this->user->idsGroup); // Convert array to JSON string
        }
        
        if ($this->user->role == 3) {
            $this->role = 'admin';
        } elseif ($this->user->role == 2) {
            $this->role = 'subadmin';
        } elseif ($this->user->role == 1) {
            $this->role = 'user';
        } else {
            $this->role = null; // Unknown role or not authenticated
        }
     
    }

    
    public function render()
    {
        return view('livewire.profile-detail');
    }
}
