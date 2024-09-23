<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Models\Users;
use Livewire\Component;

class UserList extends Component
{
    public $selectedRole = 'users'; // Default to 'users'
    public $list; // To store either users or admins

    public function mount()
    {
        $this->updateList(); // Initialize the list
    }

    // This method will be triggered when the select dropdown changes
    public function updateListBasedOnRole()
    {
        $this->updateList();
    }

    // Update the list according to selectedRole value
    public function updateList()
    {
        if ($this->selectedRole == 'users') {
            $this->list = Users::all();
        } elseif ($this->selectedRole == 'admins') {
            $this->list = Admin::all();
        }
    }

    public function render()
    {
        return view('livewire.user-list');
    }
}
