<?php

namespace App\Livewire;

use App\Models\IdsGroup;
use App\Models\Survey2Response;
use App\Models\UserSubmission;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Response;

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
        ->whereIn('response', [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10])  // Filter responses between 1-6 and 9-10
        ->groupBy('response')
        ->get()
        ->pluck('count', 'response')
        ->toArray();

        $this->userSubmissions = UserSubmission::all();
        
        $this->idsGroups = IdsGroup::all();
        $this->calculateNPS();
        

        // Fetch the responses for each submission dynamically
        foreach ($this->userSubmissions as $submission) {
            $this->responses[$submission->id] = Survey2Response::where('user_submission_id', $submission->id)
                ->orderBy('question_index')
                ->get();
        }
    }

    private function calculateNPS()
    {
        $this->totalSurveys = $this->userSubmissions->where('status', 'done')->count();
        $filteredResponses = array_diff_key($this->responseCounts, array_flip([0,7, 8, 'Na']));
        
        // Sum the filtered responses
        $this->total = array_sum($filteredResponses);
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

            $this->userSubmissions = $query->get();
            
            // Get all user_submission_ids for the filtered idsGroup and date range
            $submissionIds = $this->userSubmissions->pluck('id')->toArray();

            // Now filter Survey2Response by those user_submission_ids
            $responseQuery = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
                ->whereIn('user_submission_id', $submissionIds)
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

            $this->userSubmissions = $query->get();
             // Get all user_submission_ids for the filtered idsGroup and date range
             $submissionIds = $this->userSubmissions->pluck('id')->toArray();

            // Get response counts for all user submissions
            $responseQuery = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
                ->whereIn('user_submission_id', $submissionIds)
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
    $filename = 'user_submissions.csv';
    $columns = array_merge(['Client Name'], array_map(function ($i) {
        return "Q$i";
    }, range(1, 9)));

    // Open a temporary file in memory
    $file = fopen('php://temp', 'w');
    
    // Add the column headers to the file
    fputcsv($file, $columns);
    
    // Add each row to the CSV file
    foreach ($this->userSubmissions as $submission) {
        // Check if there are any responses for this submission
        $responses = DB::table('survey2_responses')
            ->where('user_submission_id', $submission->id) // Use correct column name
            ->orderBy('question_index')
            ->get();

        // Only proceed if responses exist
        if ($responses->isNotEmpty()) {
            $row = [];
            $row[] = $submission->clientContactName;

            // Initialize an array for responses
            $responseRow = [];
            foreach ($responses as $response) {
                $responseRow[] = $response->response ?? 'NA';
            }

            // Merge client name with the responses
            $row = array_merge($row, $responseRow);

            // Add the complete row to the CSV
            fputcsv($file, $row);
        }
    }

    // Move the file pointer to the beginning of the file
    rewind($file);

    // Store the file in a temporary variable
    $csvData = stream_get_contents($file);

    // Close the file
    fclose($file);

    // Set the file for download using Laravel's response helper
    return response($csvData)
        ->header('Content-Type', 'text/csv')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
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
