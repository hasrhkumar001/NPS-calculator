<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\IdsGroup;
use App\Models\Survey2Response;
use App\Models\UserSubmission;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
class UserDashboard extends Component
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
    public $searchGroup = '';
    public $neutralPercentage;
    public $selectedGroups = [];
    

    public function mount()
    {
    
        // Fetch the idsGroup array from the authenticated user
        $authIdsGroupArray = json_decode(auth()->user()->idsGroup, true);
        
        // Fetch all users whose idsGroup matches any of the values in the authenticated user's idsGroup
        $matchingUsers = UserSubmission::where(function ($query) use ($authIdsGroupArray) {
            foreach ($authIdsGroupArray as $group) {
               $query->orWhere('idsGroup', 'LIKE', '%' . $group . '%');
            }
            
        })->pluck('id')->sortBy('name')->toArray(); // Get the IDs of matching users
        

        // Fetch user submissions where user_id matches the matching users
        $this->userSubmissions = UserSubmission::whereIn('id', $matchingUsers)
                ->where('status', 'Done')
                ->where('user_id', auth()->id())
                ->get();
                
        //  dd($this->userSubmissions);
        $validResponses = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
         $columns = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10', 'Q11', 'Q12', 'Q13', 'Q14', 'Q15'];
     
             // Initialize an array to store counts for each response
             $counts = array_fill_keys($validResponses, 0);
     
             foreach ($validResponses as $response) {
                 $this->responseCounts = Survey2Response::selectRaw(
                     // Dynamically create the SUM(CASE WHEN) for each column
                     implode(' + ', array_map(function ($column) use ($response) {
                         return "SUM(CASE WHEN {$column} = '{$response}' THEN 1 ELSE 0 END)";
                     }, $columns)) . ' as total_count'
                 )->join('user_submissions', 'survey_responses.client_id', '=', 'user_submissions.client_id')
                 ->where('user_submissions.user_id', auth()->id())->value('total_count');
     
                 // Store the count for the current response
                 $counts[$response] = $this->responseCounts;
             }
     
             // Only keep counts where the value is greater than zero
             $this->responseCounts = array_filter($counts, function ($count) {
                 return $count > 0;
             });
 
        
        
        $this->idsGroups = json_decode(auth()->user()->idsGroup, true);
        sort($this->idsGroups);
        $this->calculateNPS();
        

        // Fetch the responses for each submission dynamically
        foreach ($this->userSubmissions as $submission) {
            $this->responses[$submission->id] = Survey2Response::where('client_id', $submission->client_id)
                ->first();
        }
    }
    public function selectGroup($value)
    {
        // dd($value);
        $this->idsGroup = $value;
       
        $this->updateListBasedOnFilters();
    }

    private function calculateNPS()
    {
        // Recalculate total number of valid surveys
        $this->totalSurveys = $this->userSubmissions->count();
        

        // Aggregate responses from responseCounts, skipping 'NA'
        $filteredResponses = array_diff_key($this->responseCounts, array_flip(['Na']));
        
        // Calculate total valid responses
        $this->total = array_sum($filteredResponses);
        
        // Default total to 1 to avoid division errors (if no responses)
        if ($this->total == 0) {
            $this->total = 1;
        }
        $this->promoters = ($this->responseCounts[9] ?? 0) + ($this->responseCounts[10] ?? 0);
        $this->neutrals = ($this->responseCounts[7] ?? 0) + ($this->responseCounts[8] ?? 0);
        $this->detractors = array_sum(array_intersect_key($this->responseCounts, array_flip(range(0, 6))));
        // dd( $this->responseCounts);
    
        // Calculate promoter and detractor percentages
        $this->promoterPercentage = round(($this->promoters / $this->total) * 100, 2);
        $this->neutralPercentage = round(($this->neutrals / $this->total) * 100, 2);
        $this->detractorPercentage = round(($this->detractors / $this->total) * 100, 2);
    
        // Calculate the final NPS score
        $this->nps = round($this->promoterPercentage - $this->detractorPercentage, 2);

        // Dispatch the event with updated data
        $this->dispatch('updateCharts', [
            'promoters' => $this->promoters,
            'neutrals' => $this->neutrals,
            'detractors' => $this->detractors,
            'promoterPercentage' => $this->promoterPercentage,
            'neutralPercentage' => $this->neutralPercentage,
            'detractorPercentage' => $this->detractorPercentage,
            'responseCounts' => $filteredResponses,
        ]);
    }
    public function toggleGroup($groupName)
    {
        if (!is_array($this->selectedGroups)) {
            $this->selectedGroups = [];
        }
    
        if (in_array($groupName, $this->selectedGroups)) {
            // Remove the group
            $this->selectedGroups = array_values(array_diff($this->selectedGroups, [$groupName]));
        } else {
            // Append the group (Livewire-friendly way)
            $this->selectedGroups[] = $groupName;
        }
        // Call filter method if needed
        $this->filter();
    }
    

    public function toggleAllGroups()
    {
        if (count($this->selectedGroups) === count($this->idsGroups)) {
            
            $this->selectedGroups = [];
           
        } else {
            $this->selectedGroups = $this->idsGroups;
        }
        
        $this->filter();
        
    }
  

public function updateListBasedOnFilters(){
    $this->filter();
}
    public function filter()
{
    $idsGroup = $this->selectedGroups;
    $dateFrom = $this->dateFrom;  
    $dateTo = $this->dateTo;      
    $csat = $this->csat;

    // Define the valid responses
    $validResponses = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    $columns = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10', 'Q11', 'Q12', 'Q13', 'Q14', 'Q15']; // Replace with actual response columns if needed
    $counts = [];
    $authIdsGroupArray = json_decode(auth()->user()->idsGroup, true);

    // Filter when idsGroup is provided
    if (!empty($idsGroup)) {
        // Filter user submissions based on idsGroup
        $query = UserSubmission::whereIn('idsGroup', $idsGroup);

        // If dateFrom is provided, filter user submissions updated after or on dateFrom
        if (!empty($dateFrom)) {
            $query = $query->where('updated_at', '>=', $dateFrom);
        }

        // If dateTo is provided, filter user submissions updated before or on dateTo
        if (!empty($dateTo)) {
            $query = $query->where('updated_at', '<=', $dateTo);
        }

        // If CSAT is provided, filter for the specific month
        if (!empty($csat)) {
            $query = $query->where('csatOccurrence', $csat);
        }

        $query = $query->where('status', 'done')->where('user_id', auth()->id());
        $this->userSubmissions = $query->get();

        // Get all user_submission_ids for the filtered idsGroup and date range
        $submissionIds = $this->userSubmissions->pluck('client_id')->toArray();

    } else {
        // If no idsGroup is selected, show all user submissions
        $query = UserSubmission::query();
        $query = UserSubmission::whereIn('idsGroup', $authIdsGroupArray);

        // If dateFrom is provided, filter by updated_at after or on dateFrom
        if (!empty($dateFrom)) {
            $query = $query->where('updated_at', '>=', $dateFrom);
        }

        // If dateTo is provided, filter by updated_at before or on dateTo
        if (!empty($dateTo)) {
            $query = $query->where('updated_at', '<=', $dateTo);
        }

        // If CSAT is provided, filter for the specific month
        if (!empty($csat)) {
            $query = $query->where('csatOccurrence', $csat);
        }

        $query = $query->where('status', 'done')->where('user_id', auth()->id());
        $this->userSubmissions = $query->get();

        // Get all user_submission_ids for the filtered idsGroup and date range
        $submissionIds = $this->userSubmissions->pluck('client_id')->toArray();
    }

    // Perform dynamic SUM(CASE WHEN) for each response across the defined columns
    foreach ($validResponses as $response) {
        $this->responseCounts = Survey2Response::selectRaw(
            implode(' + ', array_map(function ($column) use ($response) {
                return "SUM(CASE WHEN {$column} = '{$response}' THEN 1 ELSE 0 END)";
            }, $columns)) . ' as total_count'
        )->whereIn('client_id', $submissionIds)->value('total_count');

        // Store the count for the current response
        $counts[$response] = $this->responseCounts;
    }

    $this->responseCounts = $counts;

    // Calculate NPS after filtering
    return $this->calculateNPS();
}



public function downloadCSV()
{
   
    $userSubmissions = $this->userSubmissions;

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

    $callback = function () use ($userSubmissions, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        for ($i = 1; $i <= 9; $i++) {
            $row = ['Q ' . $i];
            foreach ($userSubmissions as $submission) {
                // Fetch the response for each question
                $response = $this->responses[$submission->id]->{"Q{$i}"} ?? 'NA';
                $row[] = $response;
            }
            fputcsv($file, $row);
        }

        // Add the NPS row
        $npsRow = ['NPS'];
        foreach ($userSubmissions as $submission) {
            // Calculate NPS for each submission
            $nps = $this->responses[$submission->id]->Nps_percentage; // Use the new helper method
            $npsRow[] = $nps . '%';
        }
        fputcsv($file, $npsRow);

        fclose($file);
    };
    $filteredResponses = array_diff_key($this->responseCounts, array_flip(['Na']));

    $this->dispatch('updateCharts', [
        'promoters' => $this->promoters,
        'neutrals' => $this->neutrals,
        'detractors' => $this->detractors,
        'promoterPercentage' => $this->promoterPercentage,
        'neutralPercentage' => $this->neutralPercentage,
        'detractorPercentage' => $this->detractorPercentage,
        'responseCounts' => $filteredResponses,
    ]);

    return new StreamedResponse($callback, 200, $headers);
}
        
        private function calculateNPSForSubmission($submission)
        {
            // Get the responses for the submission
            $responses = Survey2Response::where('client_id', $submission->client_id)
                ->get();

            $responseCounts = [
                'promoters' => 0,
                'detractors' => 0,
                'neutrals' => 0,
            ];

            // Count responses based on NPS categories
            foreach ($responses as $response) {
                if ($response->response >= 9 && $response->response <= 10) {
                    $responseCounts['promoters']++;
                } elseif ($response->response <= 6 && $response->response >= 0) {
                    $responseCounts['detractors']++;
                } elseif(($response->response <= 8) &&($response->response >= 7)) {
                    $responseCounts['neutrals']++;
                }
            }

            // Calculate total responses
            $totalResponses = $responseCounts['promoters'] + $responseCounts['detractors'] + $responseCounts['neutrals'];
            

            // Calculate NPS
            if ($totalResponses > 0) {
                $promoterPercentage = ($responseCounts['promoters'] / $totalResponses) * 100;
                $detractorPercentage = ($responseCounts['detractors'] / $totalResponses) * 100;
                return round($promoterPercentage - $detractorPercentage, 2);
            }

            return 0; // Return 0 if no responses found
        }
    public function render()
    {
        return view('livewire.user-dashboard',[
            'userSubmissions' => $this->userSubmissions,
            'responses' => $this->responses,
            'totalNps' => $this->nps,
        ]);
    }
}
