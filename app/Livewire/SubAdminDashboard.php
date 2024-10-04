<?php

namespace App\Livewire;

use App\Models\IdsGroup;
use App\Models\Survey2Response;
use App\Models\User;
use App\Models\UserSubmission;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubAdminDashboard extends Component
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
    public $neutralPercentage;
   

    public function mount()
    {
         // Fetch the idsGroup array from the authenticated user
         $authIdsGroupArray = json_decode(auth()->user()->idsGroup, true);

         // Fetch all users whose idsGroup matches any of the values in the authenticated user's idsGroup
         $matchingUsers = UserSubmission::where(function ($query) use ($authIdsGroupArray) {
             foreach ($authIdsGroupArray as $group) {
                $query->orWhere('idsGroup', 'LIKE', '%' . $group . '%');
             }
             
         })->pluck('user_id')->toArray(); // Get the IDs of matching users
         

         // Fetch user submissions where user_id matches the matching users
         $this->userSubmissions = UserSubmission::whereIn('user_id', $matchingUsers)
             ->where('status', 'done')
             ->get();
 
         // Fetch the response counts from survey_responses table
         $this->responseCounts = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
             ->join('user_submissions', 'survey_responses.client_id', '=', 'user_submissions.client_id')
             ->whereIn('user_submissions.user_id', $matchingUsers)
             ->whereIn('response', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
             ->groupBy('response')
             ->get()
             ->pluck('count', 'response')
             ->toArray();
       

       
       
        
        $this->idsGroups = json_decode(auth()->user()->idsGroup, true);
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


    public function filter()
    {
        $idsGroup = $this->idsGroup;
        $dateFrom = $this->dateFrom;  
        $dateTo = $this->dateTo;      
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
                ->whereIn('response', [0,1, 2, 3, 4, 5, 6, 7,8,9, 10]);  
            
          

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
                $npsRow = ['NPS'];
                foreach ($userSubmissions as $submission) {
                    // Calculate NPS for each submission
                    $nps = $this->calculateNPSForSubmission($submission);  // Use the new helper method
                    $npsRow[] = $nps . '%';
                }
                fputcsv($file, $npsRow);

                fclose($file);
            };

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
        return view('livewire.sub-admin-dashboard', [
            'userSubmissions' => $this->userSubmissions,
            'responses' => $this->responses,
            'totalNps' => $this->nps,
            
        ]);
    }
}
