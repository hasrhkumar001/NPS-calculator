<div class="container-fluid my-4">
        <div class="container-fluid my-4 bg-light shadow">
            <!-- Existing form for filters (IDS Group, CSAT, Date range) -->
            <form  wire:submit.prevent="filter">
                        <div class="row px-5 py-3">
                            <!-- Group Selection -->
                            <div class="col-lg-3 mb-3">
                                <label for="idsGroup" class="form-label">IDS Group</label>
                                <select wire:model="idsGroup" id="idsGroup" class="form-select" >
                                    <option value="">All Groups</option>
                                    @foreach($idsGroups as $group)
                                        <option value="{{ $group->name }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- CSAT Selection -->
                            <div class="col-lg-3 mb-3">
                                <label for="status" class="form-label">Pending Email</label>
                                <select id="status" class="form-select" wire:model="status">
                                    <option  value="">All</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Done">Done</option>
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label for="users" class="form-label">Users</label>
                                <select id="users" class="form-select" wire:model="user">
                                    <option  value="">All</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user['email'] }}">{{ $user['name'] }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class=" col-lg-3 mb-3 d-flex align-items-end justify-content-center">
                            <button type="submit" class="btn  btn-primary fs-5"><i class="fas fa-filter mx-2"></i>Apply Filter</button>
                        </div>
                            
                        </div>
                        
            </form>
            </div>
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
                    
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersubmissions as $users)
                    <tr class="text-center {{ $users->status === 'Pending' ? 'table-danger' : '' }} ">
                    <th scope="row">{{$loop->iteration}}</th>
                    @php
                        // Fetch the user from the database based on the ID from the $users object
                        $leadManager = \App\Models\Users::find($users->user_id);
                    @endphp
                    <td >{{$users->idsGroup}}</td>
                    <td >{{$users->projectName}}</td>
                    <td>{{ $users->idsLeadManager }} ({{ $leadManager ? $leadManager->email : 'Deleted User' }})</td>
                    <td >{{$users->clientContactName}}</td>
                    <td >{{$users->clientOrganization}}</td>
                    <td >{{$users->clientEmailAddress}}</td>
                    <td >{{$users->status}}</td>
                    <td >{{$users->updated_at}}</td>
                    
                    
                    
                </tr>
                    @endforeach
                    
                </tbody>
            </table>
</div>
