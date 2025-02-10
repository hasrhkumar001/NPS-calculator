<?php

namespace App\Livewire\Questions;

use App\Models\Question;
use Livewire\Component;

class ManageQuestions extends Component
{ public $questions = [];
    public $questionList;
    public $remainingQuestions = [];
    public $editingQuestionId;
    public $editingIndex;
    public $editingValue;
    public $showEditModal = false;
    public $groupId ; // Change as per your requirement

    public function mount()
    {
        $this->loadQuestions();
    }

    public function loadQuestions()
    {
        $this->questionList = Question::where('group_id', $this->groupId)->first();
        
        // Track remaining questions
        $this->remainingQuestions = [];
        if ($this->questionList) {
            foreach (range(1, 9) as $q) {
                if (empty($this->questionList['Q' . $q])) {
                    $this->remainingQuestions[] = $q;
                }
            }
        } else {
            $this->remainingQuestions = range(1, 9);
        }
    }

    public function addQuestions()
    {
        if (!$this->questionList) {
            $this->questionList = Question::create(['group_id' => $this->groupId]);
        }

        foreach ($this->questions as $index => $question) {
            if (!empty($question)) {
                $this->questionList->update(['Q' . $index => $question]);
            }
        }

        $this->questions = [];
        $this->loadQuestions();
        session()->flash('message', 'Questions added successfully.');
    }

    public function showEditModal($id, $index)
    {
        $question = Question::find($id);
        $this->editingQuestionId = $id;
        $this->editingIndex = $index;
        $this->editingValue = $question['Q' . $index];
        $this->showEditModal = true;
    }

    public function updateQuestion()
    {
        if ($this->editingQuestionId && $this->editingIndex) {
            Question::where('id', $this->editingQuestionId)
                ->update(['Q' . $this->editingIndex => $this->editingValue]);

            $this->showEditModal = false;
            $this->loadQuestions();
            session()->flash('message', 'Question updated successfully.');
        }
    }

    public function deleteQuestion($id, $index)
    {
        $question = Question::find($id);
        $question->update(['Q' . $index => null]);
        $this->loadQuestions();
        session()->flash('message', 'Question deleted successfully.');
    }

    public function render()
    {
        return view('livewire.questions.manage-questions');
    }
}
