<?php

namespace App\Livewire;

use App\Jobs\ProcessListJob;
use App\Models\Admin;
use App\Models\SubAdmin;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Queue;

class UserList extends Component
{
    public $selectedRole = 'all'; // Default to 'users'
    public $list; // To store either users, admins, or both

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
    $this->list = []; // Initialize as an empty array

    if ($this->selectedRole == 'users') {
        $this->list = Users::all()->map(function ($user) {
            $user->role = 'user'; // Add role information
            return $user;
        });
    } elseif ($this->selectedRole == 'subadmins') {
        $this->list = SubAdmin::all()->map(function ($subadmin) {
            $subadmin->role = 'subadmin'; // Add role information
            return $subadmin;
        });
    }elseif ($this->selectedRole == 'admins') {
        $this->list = Admin::all()->map(function ($admin) {
            $admin->role = 'admin'; // Add role information
            return $admin;
        });
    } 
    elseif ($this->selectedRole == 'all') {
        // Fetch and add admins individually
        foreach (Admin::all() as $admin) {
            $admin->role = 'admin'; // Add role information
            $this->list[] = $admin; // Add admin to the list
        }
        foreach (SubAdmin::all() as $admin) {
            $admin->role = 'subadmin'; // Add role information
            $this->list[] = $admin; // Add admin to the list
        }
        // Fetch and add users individually
        foreach (Users::all() as $user) {
            $user->role = 'user'; // Add role information
            $this->list[] = $user; // Add user to the list
        }

        
    }
    
    // No need for return statement here, as $this->list is updated directly
}

    

    public function delete($id)
    {
        $user = Users::findOrFail($id);
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
        $this->updateList();
    }

    public function deleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        if (Auth::guard('admin')->user()->id != $admin->id) {
            $admin->delete();
            session()->flash('message', 'Admin deleted successfully.');
        } else {
            session()->flash('error', 'You cannot delete your own admin account.');
        }
        $this->updateList();
    }
    public function deleteSubAdmin($id)
    {
        $admin = SubAdmin::findOrFail($id);
        if (Auth::guard('admin')->user()->id != $admin->id) {
            $admin->delete();
            session()->flash('message', 'Sub Admin deleted successfully.');
        } else {
            session()->flash('error', 'You cannot delete your own admin account.');
        }
        $this->updateList();
    }

    public function render()
    {
        return view('livewire.user-list');
    }
}
