<?php

namespace App\Livewire;

use App\Models\Users;
use Livewire\Component;

class UserList extends Component
{
    public $all_users;
    
    public function mount(){
        $this->all_users = Users::all();
    }
    public function delete($id){
        try{
            Users::where('id',$id)->delete(); 
            return $this->redirect('/users',navigate:true);
        }catch(\Exception $e){
            dd($e);
        }
    }

    
    public function render()
    {
        return view('livewire.user-list',[
            'users' => $this->all_users
        ]);
    }
}

