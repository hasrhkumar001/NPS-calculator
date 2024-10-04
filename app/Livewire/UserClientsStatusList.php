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
   

    public function mount()
    {
        $this->responseCounts = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
        ->whereIn('response', [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10])  
        ->groupBy('response')
        ->get()
        ->pluck('count', 'response')
        ->toArray();

        $this->userSubmissions = UserSubmission::where('user_id', auth()->id())
                                ->get();
        
        $this->idsGroups = IdsGroup::all();
        
        

        // Fetch the responses for each submission dynamically
        foreach ($this->userSubmissions as $submission) {
            $this->responses[$submission->id] = Survey2Response::where('client_id', $submission->client_id)
                ->orderBy('question_index')
                ->get();
        }
    }

   

    public function filter()
    {
        $idsGroup = $this->idsGroup;
        $status = $this->status;  // Assuming this is passed as a filter input
        
        

        if (!empty($idsGroup)) {
            // Filter user submissions based on idsGroup
            $query = UserSubmission::where('idsGroup', $idsGroup);
            
           
            if (!empty($status)) {
                $query = $query->where('status',  $status);
            }

            
            
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
            
            if (!empty($status)) {
                $query = $query->where('status',  $status);
            }

            
          
           
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
        
        }
        public function delete($id){
            try{
                UserSubmission::where('id',$id)->delete(); 
                return $this->redirect('/clients',navigate:true);
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
