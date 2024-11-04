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
    public function mount (){
        $this->idsGroups = IdsGroup::all();
        $this->userSubmissions = UserSubmission::orderByRaw('updated_at DESC')->get();
        $this->users = Users::all();
    }

    public function filter()
    {
        $idsGroup = $this->idsGroup;
        $status = $this->status;
        $selectedUser = $this->user;
        // dd($selectedUser);

        if (!empty($idsGroup)) {
            // Filter user submissions based on idsGroup
            $query = UserSubmission::where('idsGroup', $idsGroup);
        
            if(!empty($status)){
                $query = $query->where('status', $status);
            }
            if (!empty($selectedUser)) {
                $user = Users::where('email', $selectedUser)->pluck('id'); 
                $query = $query->where('user_id', $user); 
            }
        }
        else{
            $query = UserSubmission::query();
            if(!empty($status)){
                $query = $query->where('status', $status);
            }
            if (!empty($selectedUser)) {
                $user = Users::where('email', $selectedUser)->pluck('id'); 
                $query = $query->where('user_id', $user); 
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
            'usersubmissions' => $this->userSubmissions
        ]);
    }
}
