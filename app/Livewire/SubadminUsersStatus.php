<?php

namespace App\Livewire;

use App\Models\Users;
use Livewire\Component;
use App\Models\IdsGroup;
use App\Models\UserSubmission;
use App\Models\Survey2Response;


class SubadminUsersStatus extends Component
{
    public $responseCounts = [];
    public $totalSurveys = 0;
    public $total = 0;
    public $users;
    public $user;
    public $nps = 0;
    public $status;
    public $idsGroups;
    public $idsGroup;
    public $userSubmissions;
    public $responses = [];
   

    public function mount()
    {
        

        // Fetch the idsGroup array from the authenticated user
        $authIdsGroupArray = json_decode(auth()->user()->idsGroup, true);

        // Fetch all users whose idsGroup matches any of the values in the authenticated user's idsGroup
        $matchingUsers = UserSubmission::where(function ($query) use ($authIdsGroupArray) {
            foreach ($authIdsGroupArray as $group) {
               $query->orWhere('idsGroup', 'LIKE', '%' . $group . '%');
            }
            
        })->pluck('id')->toArray(); // Get the IDs of matching users
        
        $this->users = Users::where(function ($query) use ($authIdsGroupArray) {
            foreach ($authIdsGroupArray as $group) {
               $query->orWhere('idsGroup', 'LIKE', '%' . $group . '%');
            }
            
        })->pluck('name')->toArray();        
        // dd($users);
        // Fetch user submissions where user_id matches the matching users
        $this->userSubmissions = UserSubmission::whereIn('id', $matchingUsers)
                                ->orderByRaw('updated_at  DESC') 
                                ->get();
                        
        // dd($this->userSubmissions);

        $this->responseCounts = Survey2Response::select('response', Survey2Response::raw('count(*) as count'))
            ->whereIn('response', [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10])  
            ->join('user_submissions', 'survey_responses.client_id', '=', 'user_submissions.client_id')
            ->where('user_submissions.id', $matchingUsers) // Filter by the authenticated user's ID
            ->groupBy('response')
            ->get()
            ->pluck('count', 'response')
            ->toArray();
            
        $this->idsGroups = json_decode(auth()->user()->idsGroup, true);

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
        $status = $this->status;  
        $selectedUser = $this->user;
        
        // Fetch the idsGroup array from the authenticated user
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

            if (!empty($selectedUser)) {
                $user = Users::where('name', $selectedUser)->pluck('id'); 
                $query = $query->where('user_id', $user); 
            }

            
            
            $this->userSubmissions = $query->orderByRaw('updated_at  DESC')->get();
            
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
            $query = UserSubmission::where(function ($query) use ($authIdsGroupArray) {
                foreach ($authIdsGroupArray as $group) {
                   $query->orWhere('idsGroup', 'LIKE', '%' . $group . '%');
                };});
            
            if (!empty($status)) {
                $query = $query->where('status',  $status);
            }

            if (!empty($selectedUser)) {
                $user = Users::where('name', $selectedUser)->pluck('id'); 
                $query = $query->where('user_id', $user); 
            }
            
          
           
            $this->userSubmissions = $query
                                    ->orderByRaw('updated_at  DESC')  
                                    ->get();
            
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
                return $this->redirect('/survey-status',navigate:true);
            }catch(\Exception $e){
                dd($e);
            }
        }
    public function render()
    {
        return view('livewire.subadmin-users-status',[
            'usersubmissions' => $this->userSubmissions
        ]);
    }
}
 