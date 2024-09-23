<div class="container my-4">
        <div class="container my-4 bg-light shadow">
            <!-- Existing form for filters (IDS Group, CSAT, Date range) -->
            <form  wire:submit.prevent="filter">
                        <div class="row px-5 py-3">
                            <!-- Group Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="idsGroup" class="form-label">IDS Group</label>
                                <select wire:model="idsGroup" id="idsGroup" class="form-select" >
                                    <option value="">All Groups</option>
                                    @foreach($idsGroups as $group)
                                        <option value="{{ $group->name }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- CSAT Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Pending Email</label>
                                <select id="status" class="form-select" wire:model="status">
                                    <option  value="">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>

                            
                        </div>
                        <div class=" px-5 py-3 text-end">
                            <button type="submit" class="btn px-5 py-2 btn-primary fs-5">Filter</button>
                        </div>
            </form>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                    <th scope="col">Sr No.</th>
                    <th scope="col">Group Name</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">IDS Lead/Manager</th>
                    <th scope="col">Client Contact Name</th>
                    <th scope="col">Client Organization</th>
                    <th scope="col">Client Email</th>
                    <th scope="col">Email Reply Status</th>
                    <th scope="col">Date</th>
                    
                    
                    <th scope="col" colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersubmissions as $users)
                    <tr class="text-center">
                    <th scope="row">{{$loop->iteration}}</th>
                    
                    <td >{{$users->idsGroup}}</td>
                    <td >{{$users->projectName}}</td>
                    <td >{{$users->idsLeadManager}}</td>
                    <td >{{$users->clientContactName}}</td>
                    <td >{{$users->clientOrganization}}</td>
                    <td >{{$users->clientEmailAddress}}</td>
                    <td >{{$users->status}}</td>
                    <td >{{$users->updated_at}}</td>
                    
                    
                    
                    <td ><button class="btn btn-danger btn-sm shadow" wire:click="delete({{$users->id}})" wire:confirm="Are you sure you want to delete this? ">DELETE</button></td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
</div>
