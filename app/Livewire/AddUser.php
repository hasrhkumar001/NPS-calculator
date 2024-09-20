<?php

namespace App\Livewire;

use App\Models\AdminSignup;
use App\Models\Users;
use Livewire\Component;
use App\Models\IdsGroup;


class AddUser extends Component
{
    public $name ='';
    public $email ='';
    public $password ='';

    public $role ='';
    public $idsGroup ='';
    public $idsGroups;
    

    public function mount(){
        $this->idsGroups = IdsGroup::all();
    }
    
    public function saveUser(){
        $this->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            
            
            // 'idsGroup' is required only if role is 'user'
            'idsGroup' => $this->role === 'user' ? 'required' : 'nullable',
            
        ]);
        
       
        if($this->role =="0"){
            $new_user =new Users;
            $new_user->name =$this->name;
            $new_user->email=$this->email;
            $new_user->idsGroup=$this->idsGroup;
            
            $new_user->password =bcrypt($this->password);
        }
        elseif($this->role =="1"){

        $new_user =new AdminSignup;
        $new_user->name =$this->name;
        $new_user->email =$this->email;
        $new_user->password =bcrypt($this->password);
        }
        $new_user->save();
        
       
        
        return $this->redirect('/add-users',navigate:true);
    }
    public function render()
    {
        return view('livewire.add-user');
    }
}
