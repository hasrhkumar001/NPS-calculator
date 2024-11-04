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
    public $search = ''; 

    public function mount()
    {
        $this->updateList(); // Initialize the list
    }

    // This method will be triggered when the select dropdown changes
    public function updateListBasedOnRole()
    {
        $this->updateList();
    }
    public function updatedSearch()
    {
        // Update the search term when input changes
        $this->updateList(); // Update the list with the new search term
    }

    public function searchUsers()
    {
        // Call the updateList method to refresh the list based on the current search value
        $this->updateList();
    }
   
    // Update the list according to selectedRole value
    public function updateList()
    {
        $query = Users::query();

        if ($this->selectedRole === 'users') {
            $query->where('role', 1);
        } elseif ($this->selectedRole === 'subadmins') {
            $query->where('role', 2);
        } elseif ($this->selectedRole === 'admins') {
            $query->where('role', 3);
        }

        // Apply search filter if there is input
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Set the filtered list
        $this->list = $query->orderByRaw("FIELD(role, '3', '2', '1')")->get();
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
        $admin = Users::findOrFail($id);
        if (Auth::user()->id != $admin->id) {
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
