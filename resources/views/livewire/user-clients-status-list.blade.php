
    <div class="container my-4">
        <div class="container my-5 bg-light shadow">
            <!-- Existing form for filters (IDS Group, CSAT, Date range) -->
            <form  wire:submit.prevent="filter">
                        <div class="row px-5 py-3">
                            <!-- Group Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="idsGroup" class="form-label">IDS Group</label>
                                <select wire:model="idsGroup" id="idsGroup" class="form-select" >
                                    <option value="">All Groups</option>
                                    @foreach($idsGroups as $group)
                                        <option value="{{ $group }}">{{ $group }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="csat" class="form-label">Status</label>
                                <select id="csat" class="form-select" wire:model="status">
                                    <option  value="">All</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Done">Done</option>
                                    
                                </select>
                            </div>
                        </div>

                        
                        <div class=" px-5 py-3 text-end">
                            <button type="submit" class="btn px-5 py-2 btn-primary fs-5"><i class="fas fa-filter mx-2"></i>Apply Filter</button>
                        </div>      
                    </div>

                    
            </form>

       

      <!-- Table Rendering the Responses -->
      <div class="table-responsive my-4">
      <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                    <th scope="col">Sr No.</th>
                    <th scope="col">Group Name</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">IDS Lead/Manager</th>
                    <th scope="col">Client Contact Name</th>
                    <th scope="col">Client Organization</th>
                    <th scope="col">Client Email</th>
                    <th scope="col">Survey Status</th>
                    <th scope="col">Date</th>
                    
                    
                    <!-- <th scope="col" colspan="2">Actions</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersubmissions as $users)
                    <tr class="text-center  {{ $users->status === 'Pending' ? 'table-danger' : '' }}    ">
                    <th scope="row">{{$loop->iteration}}</th>
                    @php
                        // Fetch the user from the database based on the ID from the $users object
                        $leadManager = \App\Models\Users::find($users->user_id);
                    @endphp
                    <td >{{$users->idsGroup}}</td>
                    <td >{{$users->projectName}}</td>
                    <td >{{$users->idsLeadManager}} ({{ $leadManager ? $leadManager->email : 'Deleted User' }})</td>
                    <td >{{$users->clientContactName}}</td>
                    <td >{{$users->clientOrganization}}</td>
                    <td >{{$users->clientEmailAddress}}</td>
                    <td >{{$users->status}}</td>
                    <td >{{$users->updated_at}}</td>
                    
                    
                    
                    <!-- <td ><button class="btn btn-danger btn-sm shadow" wire:click="delete({{$users->id}})" wire:confirm="Are you sure you want to delete this? ">DELETE</button></td> -->
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
    </div>

    
</div>


