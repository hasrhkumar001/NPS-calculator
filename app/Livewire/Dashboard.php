<?php

namespace App\Livewire;

use App\Models\IdsGroup;
use App\Models\Survey2Response;
use App\Models\UserSubmission;
use Livewire\Component;
use Request;

class Dashboard extends Component
{
    public $responseCounts = [];
    public $totalSurveys = 0;
    public $total = 0;
    public $promoters = 0;
    public $neutrals = 0;
    public $detractors = 0;
    public $nps = 0;
    public $idsGroups;
    public $idsGroup;
    public $userSubmissions;
    public $responses = [];

    public function mount()
    {
        $this->responseCounts = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
            ->groupBy('response')
            ->get()
            ->pluck('count', 'response')
            ->toArray();

        $this->calculateNPS();
        $this->idsGroups = IdsGroup::all();
        $this->userSubmissions = UserSubmission::all();

        // Fetch the responses for each submission dynamically
        foreach ($this->userSubmissions as $submission) {
            $this->responses[$submission->id] = Survey2Response::where('user_submission_id', $submission->id)
                ->orderBy('question_index')
                ->get();
        }
    }

    private function calculateNPS()
    {
        $this->totalSurveys = UserSubmission::where('status', 'done')->count();
        $this->total = array_sum($this->responseCounts);

        $this->promoters = ($this->responseCounts[9] ?? 0) + ($this->responseCounts[10] ?? 0);
        $this->neutrals = ($this->responseCounts[7] ?? 0) + ($this->responseCounts[8] ?? 0);
        $this->detractors = array_sum(array_intersect_key($this->responseCounts, array_flip(range(0, 6))));

        $promoterPercentage = ($this->promoters / $this->total) * 100;
        $detractorPercentage = ($this->detractors / $this->total) * 100;

        $this->nps = round($promoterPercentage - $detractorPercentage, 2);
    }


    public function filter(){
        
        $idsGroup = $this->idsGroup;

        
        if (!empty($idsGroup)) {
            // Filter user submissions based on idsGroup
            $this->userSubmissions = UserSubmission::where('idsGroup', $idsGroup)->get();

            // dd($this->userSubmissions);
        
        } else {
            // If no idsGroup is selected, show all user submissions
            $this->userSubmissions = UserSubmission::all();
            // dd($this->userSubmissions);
        }
        
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'userSubmissions' => $this->userSubmissions,
            'responses' => $this->responses,
            'totalNps' => $this->nps,
        ]);
    }
}
