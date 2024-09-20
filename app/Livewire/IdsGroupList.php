<?php

namespace App\Livewire;

use App\Models\IdsGroup;
use Livewire\Component;

class IdsGroupList extends Component
{
    public $groups;

    public function mount()
    {
        $this->groups = IdsGroup::all();
    }
    public function delete($id)
    {
        try {
            // Find the group by its id and delete it
            IdsGroup::where('id', $id)->delete();
    
            // Set a success message to display after deletion
            session()->flash('message', 'Group deleted successfully!');
    
            // Redirect to the list page after deletion
            return $this->redirect('/ids-groups', navigate: true);
        } catch (\Exception $e) {
            // In case of an exception, dump the error for debugging
            dd($e);
        }
    }

    public function render()
    {
        return view('livewire.ids-group-list', ['groups' => $this->groups]);
    }
}
