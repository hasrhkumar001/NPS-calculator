<?php

namespace App\Livewire;

use App\Models\IdsGroup;
use App\Models\Survey2Response;
use App\Models\UserSubmission;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
    public $dateFrom;
    public $dateTo;
    public $csat;
    public $promoterPercentage;
    public $detractorPercentage;
   

    public function mount()
    {
        $this->responseCounts = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
        ->whereIn('response', [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10])  
        ->groupBy('response')
        ->get()
        ->pluck('count', 'response')
        ->toArray();

        $this->userSubmissions = UserSubmission::where('status', 'done')->get();
        
        $this->idsGroups = IdsGroup::all();
        $this->calculateNPS();
        

        // Fetch the responses for each submission dynamically
        foreach ($this->userSubmissions as $submission) {
            $this->responses[$submission->id] = Survey2Response::where('client_id', $submission->client_id)
                ->orderBy('question_index')
                ->get();
        }
    }

    private function calculateNPS()
    {
        $this->totalSurveys = $this->userSubmissions->where('status', 'done')->count();
        
        
        // Sum the filtered responses
        $this->total = array_sum($this->responseCounts);
        // Set total to 1 if no valid responses were found
        if ($this->total == 0) {
            $this->total = 1;
        }

        $this->promoters = ($this->responseCounts[9] ?? 0) + ($this->responseCounts[10] ?? 0);
        $this->neutrals = ($this->responseCounts[7] ?? 0) + ($this->responseCounts[8] ?? 0);
        $this->detractors = array_sum(array_intersect_key($this->responseCounts, array_flip(range(0, 6))));

        $this->promoterPercentage = round(($this->promoters / $this->total) * 100, 2);
        $this->detractorPercentage = round((array_sum(array_intersect_key($this->responseCounts, array_flip(range(1, 6)))) / $this->total) * 100, 2);


        $this->nps = round($this->promoterPercentage - $this->detractorPercentage, 2);
    }


    public function filter()
    {
        $idsGroup = $this->idsGroup;
        $dateFrom = $this->dateFrom;  // Assuming this is passed as a filter input
        $dateTo = $this->dateTo;      // Assuming this is passed as a filter input
        $csat = $this->csat;
        

        if (!empty($idsGroup)) {
            // Filter user submissions based on idsGroup
            $query = UserSubmission::where('idsGroup', $idsGroup);
            
            // If dateFrom is provided, filter user submissions updated after or on dateFrom
            if (!empty($dateFrom)) {
                $query = $query->where('updated_at', '>=', $dateFrom);
            }

            // If dateTo is provided, filter user submissions updated before or on dateTo
            if (!empty($dateTo)) {
                $query = $query->where('updated_at', '<=', $dateTo);
            }
            if (!empty($csat)) {
                // Filter for the current month
                $query = $query->where('csatOccurrence', $csat);;
            }
            $query = $query->where('status', 'done');
            $this->userSubmissions = $query->get();
            
            // Get all user_submission_ids for the filtered idsGroup and date range
            $submissionIds = $this->userSubmissions->pluck('client_id')->toArray();

            // Now filter Survey2Response by those user_submission_ids
            $responseQuery = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
                ->whereIn('client_id', $submissionIds)
                ->whereIn('response', [0,1, 2, 3, 4, 5, 6, 7,8,9, 10]);  // Filter responses between 1-6 and 9-10
            
          

            $this->responseCounts = $responseQuery->groupBy('response')
                ->get()
                ->pluck('count', 'response')
                ->toArray();

        } else {
            // If no idsGroup is selected, show all user submissions
            $query = UserSubmission::query();
            
            // If dateFrom is provided, filter by updated_at after or on dateFrom
            if (!empty($dateFrom)) {
                $query = $query->where('updated_at', '>=', $dateFrom);
            }

            // If dateTo is provided, filter by updated_at before or on dateTo
            if (!empty($dateTo)) {
                $query = $query->where('updated_at', '<=', $dateTo);
            }
            if (!empty($csat)) {
                // Filter for the current month
                $query = $query->where('csatOccurrence', $csat);;
            }
            $query = $query->where('status', 'done');
            $this->userSubmissions = $query->get();
             // Get all user_submission_ids for the filtered idsGroup and date range
             $submissionIds = $this->userSubmissions->pluck('client_id')->toArray();

            // Get response counts for all user submissions
            $responseQuery = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
                ->whereIn('client_id', $submissionIds)
                ->whereIn('response', [0,1, 2, 3, 4, 5, 6,7,8, 9, 10]);

        

            $this->responseCounts = $responseQuery->groupBy('response')
                ->get()
                ->pluck('count', 'response')
                ->toArray();
                 }

        // Calculate NPS after filtering
        return $this->calculateNPS();
        }


        public function downloadCSV()
        {
            $userSubmissions = UserSubmission::with('responses')
                                ->where('status', 'done')
                                ->get();

            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=user_submissions.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];

            // Prepare columns with NPS column
            $columns = ['Question #'];
            foreach ($userSubmissions as $submission) {
                $columns[] = $submission->clientContactName . ' (' . $submission->updated_at->format('Y-m-d') . ')';
            }
              // Add NPS as the last column

            $callback = function() use ($userSubmissions, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                for ($i = 1; $i <= 9; $i++) {
                    $row = ['Q ' . $i];
                    foreach ($userSubmissions as $submission) {
                        // Fetch the response for each question
                        $response = $submission->responses->where('question_index', $i)->first();
                        $row[] = $response ? $response->response : 'NA';
                    }
                    fputcsv($file, $row);
                }

                // Add the NPS row
                // $npsRow = ['NPS'];
                // foreach ($userSubmissions as $submission) {
                //     // Calculate NPS for each submission
                //     $nps = $this->calculateNPSForSubmission($submission);  // Helper method to calculate NPS
                //     $npsRow[] = $nps;
                // }
                // fputcsv($file, $npsRow);

                fclose($file);
            };

            return new StreamedResponse($callback, 200, $headers);
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
