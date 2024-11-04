<?php

namespace App\Livewire;

use App\Models\IdsGroup;
use Livewire\Component;

class IdsGroupList extends Component
{public $groups; // To store the list of groups
    public $search = ''; // To store the search term

    public function mount()
    {
        $this->updateList(); // Initialize the groups list
    }

    public function updatedSearch()
    {
        $this->updateList(); // Update the list with the new search term
    }

    public function searchGroup()
    {
        $this->updateList(); // Update the list based on the current search value
    }

    public function updateList()
    {
        $query = IdsGroup::query();

        // Apply search filter if there is input
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Set the filtered list
        $this->groups = $query->get();
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
