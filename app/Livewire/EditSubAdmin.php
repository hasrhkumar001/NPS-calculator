<?php

namespace App\Livewire;


use App\Models\IdsGroup;
use App\Models\SubAdmin;
use App\Models\Users;
use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EditSubAdmin extends Component
{
    public $subAdminId;
    public $name;
    public $email;
    public $password;

    public $idsGroup;
    public $idsGroups;
    
    public $role; // Assuming admins have roles

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'sometimes|nullable|min:6',
        'idsGroup' => 'required',
        
    ];

    public function mount($subAdminId)
    {
        $this->subAdminId = $subAdminId;
        $subadmin = Users::findOrFail($subAdminId);
        $this->name = $subadmin->name;
        $this->email = $subadmin->email;
        $this->idsGroup = json_decode($subadmin->idsGroup, true); // Fetch the current IDS group of the user
        $this->idsGroups = IdsGroup::all();
        
    }

    public function updateAdmin()
    {
        $this->rules['email'] = [
            'required',
            'email',
            'max:255',
            Rule::unique('admins')->ignore($this->subAdminId),
        ];

        $this->validate();

        $admin = Users::findOrFail($this->subAdminId);
        $admin->name = $this->name;
        $admin->email = $this->email;
        $admin->idsGroup = $this->idsGroup;
        
        
        if ($this->password) {
            $admin->password = Hash::make($this->password);
        }

        $admin->save();

        session()->flash('message', 'Sub Admin updated successfully.');
        return back();
        
    }
    public function render()
    {
        return view('livewire.edit-sub-admin');
    }
}
