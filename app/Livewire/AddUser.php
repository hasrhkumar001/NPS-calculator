<?php

namespace App\Livewire;

use App\Mail\WelcomeMail;
use App\Models\AdminSignup;
use App\Models\SubAdmin;
use App\Models\SubAdminSignup;
use App\Models\Users;
use Livewire\Component;
use App\Models\IdsGroup;
use Illuminate\Support\Str; // Import Str for random string generation
use Illuminate\Support\Facades\Mail; // Import Mail for sending emails
use App\Mail\UserCredentials; // Make sure to create this Mailable


class AddUser extends Component
{
    public $name ='';
    public $email ='';
    public $password ='';

    public $role ='';
    public $idsGroup =[];
    public $idsGroups;
    

    public function mount(){
        $this->idsGroups = IdsGroup::all();
    }
    
    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'role' => 'required',
        
    ];
    protected $listeners = ['updateSelectedGroups'];

    public function updateSelectedGroups($selected)
    {
        $this->idsGroup = $selected; // Update Livewire property
        
    }

    
    public function saveUser(){
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'role' => 'required',
            'idsGroup' =>  $this->role === '2' ? 'nullable' : 'required', 
    
        ]);
         // Event listener to update idsGroup from custom dropdown
        
       
        $userExists = Users::where('email', $this->email)->exists() ||
                  SubAdminSignup::where('email', $this->email)->exists() ||
                  AdminSignup::where('email', $this->email)->exists();

        if ($userExists) {
            session()->flash('error', 'A user with this email already exists!');
            return;
        }
            
       // Generate a random password of length 10
       $this->password = Str::random(10);
      

        if($this->role =="0"){
            $new_user =new Users;
            $new_user->name =$this->name;
            $new_user->email=$this->email;
            $new_user->idsGroup = json_encode($this->idsGroup);
            $new_user->password =bcrypt($this->password);
            $new_user->save();
            session()->flash('message', 'User added successfully!');
        }
        elseif($this->role =="1"){

        $new_subadmin =new SubAdminSignup;
        $new_subadmin->name =$this->name;
        $new_subadmin->email =$this->email;
        $new_subadmin->password =bcrypt($this->password);
        $new_subadmin->idsGroup = json_encode($this->idsGroup);
        $new_subadmin->save();

        
        session()->flash('message', 'Sub Admin added successfully!');
        }
        elseif($this->role =="2"){

            $new_admin =new AdminSignup;
            $new_admin->name =$this->name;
            $new_admin->email =$this->email;
            $new_admin->password =bcrypt($this->password);
            $new_admin->save();
    

            session()->flash('message', 'Admin added successfully!');
            }
        

         // Send email with the credentials
        Mail::to($this->email)->send(new WelcomeMail($this->name, $this->email, $this->password));
        
        
        return $this->redirect('/add-users',navigate:true);
    }
    public function render()
    {
        return view('livewire.add-user');
    }
}
