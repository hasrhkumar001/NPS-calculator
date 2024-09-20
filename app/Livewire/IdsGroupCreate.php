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
