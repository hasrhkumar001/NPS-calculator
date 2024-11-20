
    <div class="container-fluid my-4">
        <div class="container-fluid my-3 bg-light shadow">
            <!-- Existing form for filters (IDS Group, CSAT, Date range) -->
            <form  wire:submit.prevent="filter">
                        <div class="row px-5 py-3">
                            <!-- Group Selection -->
                            <div class="col-lg-4 mb-3">
                            <label for="idsGroup" class="form-label">IDS Group</label>
                            <div class="position-relative">
                                <div class="custom-select" x-data="{ open: false }">
                                    <div class="select-header form-select d-flex justify-content-between align-items-center cursor-pointer" 
                                        @click="open = !open">
                                        <span>{{ $idsGroup ?: 'All Groups' }}</span>
                                        
                                    </div>
                                    
                                    <div x-show="open" 
                                        @click.outside="open = false"
                                        class="select-dropdown shadow" 
                                        style="display: none;">
                                        <div class="px-2 py-2">
                                            <input type="text" 
                                                class="form-control" 
                                                wire:model.live="searchGroup" 
                                                placeholder="Search groups..."
                                                @click.stop>
                                        </div>
                                        <div class="select-options max-h-60 overflow-y-auto">
                                            <div class="select-option hover:bg-gray-100 cursor-pointer p-2" 
                                                wire:click="selectGroup('')"
                                                @click="open = false">
                                                All Groups
                                            </div>
                                            @foreach($idsGroups as $group)
                                                @if(empty($searchGroup) || str_contains(strtolower($group), strtolower($searchGroup)))
                                                    <div class="select-option hover:bg-gray-100 cursor-pointer p-2" 
                                                        wire:click="selectGroup('{{ $group }}')" 
                                                        @click="open = false">
                                                        {{ $group }}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Survey Status Selection -->
                        <div class="col-lg-4 mb-3">
                            <label for="status" class="form-label">Survey Status</label>
                            <select id="status" class="form-select" wire:model="status" wire:change="updateListBasedOnFilters">
                                <option value="">All</option>
                                <option value="Pending">Pending</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>

                        <!-- Users Selection -->
                        <div class="col-lg-4 mb-3">
                            <label for="users" class="form-label">Users</label>
                            <div class="position-relative">
                                <div class="custom-select" x-data="{ open: false }">
                                    <div class="select-header form-select d-flex justify-content-between align-items-center cursor-pointer" 
                                        @click="open = !open">
                                        <span>{{ $user ? collect($users)->firstWhere('email', $user)['name'] : 'All Users' }}</span>
                                        
                                    </div>
                                    
                                    <div x-show="open" 
                                        @click.outside="open = false"
                                        class="select-dropdown shadow" 
                                        style="display: none;">
                                        <div class="px-2 py-2">
                                            <input type="text" 
                                                class="form-control" 
                                                wire:model.live="searchUser" 
                                                placeholder="Search users..."
                                                @click.stop>
                                        </div>
                                        <div class="select-options max-h-60 overflow-y-auto">
                                            <div class="select-option hover:bg-gray-100 cursor-pointer p-2" 
                                                wire:click="selectUser('')"
                                                @click="open = false">
                                                All Users
                                            </div>
                                            @foreach($users as $userOption)
                                                @if(empty($searchUser) || 
                                                    str_contains(strtolower($userOption['name']), strtolower($searchUser)) || 
                                                    str_contains(strtolower($userOption['email']), strtolower($searchUser)))
                                                    <div class="select-option hover:bg-gray-100 cursor-pointer p-2" 
                                                        wire:click="selectUser('{{ $userOption['email'] }}')"
                                                        @click="open = false">
                                                        {{ $userOption['name'] }}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                             <!-- <div class=" col-lg-3 mb-3 d-flex align-items-end justify-content-center">
                            <button type="submit" class="btn  btn-primary fs-5"><i class="fas fa-filter mx-2"></i>Apply Filter</button>
                        </div> -->
                        </div>

                        
                        <!-- <div class=" px-5 py-3 text-end">
                            <button type="submit" class="btn px-5 py-2 btn-primary fs-5"><i class="fas fa-filter mx-2"></i>Apply Filter</button>
                        </div>       -->
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
                    <td>{{ $users->idsLeadManager }} ({{ $leadManager ? $leadManager->email : 'Deleted User' }})</td>
                    <td >{{$users->clientContactName}}</td>
                    <td >{{$users->clientOrganization}}</td>
                    <td style="white-space: normal; overflow-wrap: break-word; max-width: 20ch;">{{$users->clientEmailAddress}}</td>
                    <td >{{$users->status}}</td>
                    <td >{{$users->updated_at}}</td>
                    
                    
                    
                    <!-- <td ><button class="btn btn-danger btn-sm shadow" wire:click="delete({{$users->id}})" wire:confirm="Are you sure you want to delete this? ">DELETE</button></td> -->
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
    </div>

    
</div>


