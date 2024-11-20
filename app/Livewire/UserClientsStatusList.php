<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\IdsGroup;
use App\Models\Survey2Response;
use App\Models\UserSubmission;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserClientsStatusList extends Component
{
    public $responseCounts = [];
    public $totalSurveys = 0;
    public $total = 0;
    
    public $nps = 0;
    public $status;
    public $idsGroups;
    public $idsGroup;
    public $userSubmissions;
    public $responses = [];
    public $searchGroup = '';

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
        
        // dd($matchingUsers);
        // Fetch user submissions where user_id matches the matching users
        $this->userSubmissions = UserSubmission::whereIn('id', $matchingUsers)
                ->where('user_id',auth()->user()->id)
                ->orderByRaw('updated_at DESC') 
                ->get();
        
        // dd($this->userSubmissions);
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
                 ->where('user_submissions.id', $matchingUsers)->value('total_count');
     
                 // Store the count for the current response
                 $counts[$response] = $this->responseCounts;
             }
     
             // Only keep counts where the value is greater than zero
             $this->responseCounts = array_filter($counts, function ($count) {
                 return $count > 0;
             });

        // $this->responseCounts = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
        //     ->whereIn('response', [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10])  
        //     ->join('user_submissions', 'survey_responses.client_id', '=', 'user_submissions.client_id')
        //     ->where('user_submissions.id', $matchingUsers) // Filter by the authenticated user's ID
        //     ->groupBy('response')
        //     ->get()
        //     ->pluck('count', 'response')
        //     ->toArray();
            
        $this->idsGroups = json_decode(auth()->user()->idsGroup, true);
        sort($this->idsGroups);

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

   

    public function updateListBasedOnFilters(){
        $this->filter();
    }
    public function filter()
    {
        $idsGroup = $this->idsGroup;
        $status = $this->status;
        
        $authIdsGroupArray = json_decode(auth()->user()->idsGroup, true);

        // Fetch all users whose idsGroup matches any of the values in the authenticated user's idsGroup
        $matchingUsers = UserSubmission::where(function ($query) use ($authIdsGroupArray) {
            foreach ($authIdsGroupArray as $group) {
               $query->orWhere('idsGroup', 'LIKE', '%' . $group . '%');
            }
            
        })->pluck('id')->toArray(); // Get the IDs of matching users

        
        
        if (!empty($idsGroup)) {
            
            // Filter user submissions based on idsGroup
            $query = UserSubmission::where('idsGroup', $idsGroup);
            
           
            if (!empty($status)) {
                $query = $query->where('status',  $status);
            }

            $this->userSubmissions = $query->where('user_id',  auth()->user()->id)->orderByRaw('updated_at DESC')->get();
            
            // Get all user_submission_ids for the filtered idsGroup and date range
            $submissionIds = $this->userSubmissions->pluck('client_id')->toArray();

            // Now filter Survey2Response by those user_submission_ids
            // $responseQuery = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
            //     ->whereIn('client_id', $submissionIds)
            //     ->whereIn('response', [0,1, 2, 3, 4, 5, 6, 7,8,9, 10]);  // Filter responses between 1-6 and 9-10
            
          

            // $this->responseCounts = $responseQuery->groupBy('response')
            //     ->get()
            //     ->pluck('count', 'response')
            //     ->toArray();

        } else {
            // If no idsGroup is selected, show all user submissions
            $query = UserSubmission::where('user_id', auth()->id());;
            
            if (!empty($status)) {
                $query = $query->where('status',  $status);
            }

            
          
           
            $this->userSubmissions = $query
                                    ->where('user_id',  auth()->user()->id)
                                    ->orderByRaw('updated_at DESC')  
                                    ->get();
            
             // Get all user_submission_ids for the filtered idsGroup and date range
             $submissionIds = $this->userSubmissions->pluck('client_id')->toArray();

            // Get response counts for all user submissions
            // $responseQuery = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
            //     ->whereIn('client_id', $submissionIds)
            //     ->whereIn('response', [0,1, 2, 3, 4, 5, 6,7,8, 9, 10]);

        

            // $this->responseCounts = $responseQuery->groupBy('response')
            //     ->get()
            //     ->pluck('count', 'response')
            //     ->toArray();
                 }
            $validResponses = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            $columns = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10', 'Q11', 'Q12', 'Q13', 'Q14', 'Q15']; // Replace with actual response columns if needed
            $counts = [];
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

        
        
        }
        public function delete($id){
            try{
                UserSubmission::where('id',$id)->delete(); 
                return $this->redirect('/survey-status',navigate:true);
            }catch(\Exception $e){
                dd($e);
            }
        }
    public function render()
    {
        return view('livewire.user-clients-status-list',[
            'usersubmissions' => $this->userSubmissions
        ]);
    }
}
