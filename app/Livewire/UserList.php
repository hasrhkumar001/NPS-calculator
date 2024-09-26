<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
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
    public function delete($id)
    {
       
            $user = Users::findOrFail($id);
            
                $user->delete();
                session()->flash('message', 'User soft deleted successfully.');
           
        
        $this->updateList();
    }

    public function deleteAdmin($id)
    {
        if ($this->selectedRole == 'admins') {
            $admin = Admin::findOrFail($id);
            if (Auth::guard('admin')->user()->id != $admin->id) {
                $admin->delete();
                session()->flash('message', 'Admin soft deleted successfully.');
            } else {
                session()->flash('error', 'You cannot delete your own admin account.');
            }
        } else {
            session()->flash('error', 'Invalid role selected for deletion.');
        }
        $this->updateList();
    }

    public function render()
    {
        return view('livewire.user-list');
    }
}
