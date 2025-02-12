<?php

namespace App\Livewire;

use App\Models\IdsGroup;
use App\Models\Users;
use App\Models\UserSubmission;
use Livewire\Component;

class UserStatusList extends Component
{
    public $idsGroups;
    public $status;
    public $users;
    public $user;
    public $idsGroup;
    public $userSubmissions;
    public $searchGroup = '';
    public $searchUser = '';
    public $selectedGroups=[];
    public $selectedUsers =[];
    
    // Dropdown state
  

    public function mount (){
        $this->idsGroups = IdsGroup::all()->sortBy('name');
        $this->userSubmissions = UserSubmission::orderByRaw('updated_at DESC')->get();
        $this->users = Users::all()->sortBy('name');
    }
    
   

    public function toggleGroup($groupName)
    {
        if (!is_array($this->selectedGroups)) {
            $this->selectedGroups = [];
        }
    
        if (in_array($groupName, $this->selectedGroups)) {
            // Remove the group
            $this->selectedGroups = array_values(array_diff($this->selectedGroups, [$groupName]));
        } else {
            // Append the group (Livewire-friendly way)
            $this->selectedGroups[] = $groupName;
        }
        // Call filter method if needed
        $this->filter();
    }
    

    public function toggleAllGroups()
    {
        if (count($this->selectedGroups) === count($this->idsGroups)) {
            $this->selectedGroups = [];
        } else {
            $this->selectedGroups = $this->idsGroups->pluck('name')->toArray();
        }
        
        $this->filter();
        
    }
    public function toggleUser($email)
    {
        if (!is_array($this->selectedUsers)) {
            $this->selectedUsers = [];
        }
        if (in_array($email, $this->selectedUsers)) {
            $this->selectedUsers = array_values(array_diff($this->selectedUsers, [$email]));
        } else {
            $this->selectedUsers[] = $email;
        }
        $this->filter();
    }

    public function toggleAllUsers()
    {
        if (count($this->selectedUsers) === count($this->users)) {
            $this->selectedUsers = [];
        } else {
            $this->selectedUsers = $this->users->pluck('email')->toArray();
        }
        $this->filter();
    }
    


    public function selectGroup($value)
    {
        // dd($value);
        $this->idsGroup = $value;
       
        $this->updateListBasedOnFilters();
    }

    public function selectUser($value)
    {
        $this->user = $value;
       
        $this->updateListBasedOnFilters();
    }

    
    public function updateListBasedOnFilters(){
        $this->filter();
    }
    public function filter()
    {
        $idsGroup = $this->selectedGroups;
        $status = $this->status;
        $selectedUser = $this->selectedUsers;
        // dd($selectedUser);

        if (!empty($idsGroup)) {
            // Filter user submissions based on idsGroup
            $query = UserSubmission::whereIn('idsGroup', $idsGroup);
        
            if(!empty($status)){
                $query = $query->where('status', $status);
            }
            if (!empty($selectedUser)) {
                $user = Users::whereIn('email', $selectedUser)->pluck('id'); 
                $query = $query->whereIn('user_id', $user); 
            }
        }
        else{
            $query = UserSubmission::query();
            if(!empty($status)){
                $query = $query->where('status', $status);
            }
            if (!empty($selectedUser)) {
                $user = Users::whereIn('email', $selectedUser)->pluck('id'); 
                $query = $query->whereIn('user_id', $user); 
            }
        }

        $this->userSubmissions = $query->orderByRaw('updated_at DESC') ->get();
            

    }
    public function delete($id){
        try{
            UserSubmission::where('id',$id)->delete(); 
            return $this->redirect('/all-surveys-status',navigate:true);
        }catch(\Exception $e){
            dd($e);
        }
    }
    public function render()
    {
        return view('livewire.user-status-list',[
            'usersubmissions' => $this->userSubmissions,
            'filteredUsers' => $this->searchUser
            ? $this->users->filter(fn($user) => stripos($user->name, $this->searchUser) !== false)
            : $this->users,
       
  
        ]);
    }
}
