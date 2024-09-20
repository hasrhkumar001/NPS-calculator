<?php

namespace App\Livewire;

use App\Models\IdsGroup;
use Livewire\Component;

class IdsGroupEdit extends Component
{
    public $group;
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function mount(IdsGroup $group)
    {
        $this->group = $group;
        $this->name = $group->name;
        
    }

    public function submit()
    {
        $this->validate();

        $this->group->update([
            'name' => $this->name,
            
        ]);

        session()->flash('message', 'Group updated successfully!');
    }

    public function render()
    {
        return view('livewire.ids-group-edit');
    }
}
