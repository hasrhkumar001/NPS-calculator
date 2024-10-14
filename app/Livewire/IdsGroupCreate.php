<?php

namespace App\Livewire;

use App\Models\IdsGroup;
use Livewire\Component;

class IdsGroupCreate extends Component
{
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        
    ];

    public function submit()
    {
        $this->validate();

        // Check if a group with the same name already exists
        $existingGroup = IdsGroup::where('name', $this->name)->first();

        if ($existingGroup) {
            // If a group with the same name exists, show an error message
            session()->flash('error', 'A group with this name already exists!');
            return;
        }
        
        IdsGroup::create([
            'name' => $this->name,
            
        ]);

        session()->flash('message', 'Group created successfully!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.ids-group-create');
    }
}
