
    <div class="container-fluid my-4">
        <div class="container-fluid my-3 bg-light shadow">
            <!-- Existing form for filters (IDS Group, CSAT, Date range) -->
            <form  wire:submit.prevent="filter">
                        <div class="row px-5 py-3">
                            <!-- Group Selection -->
                            <div class="col-lg-4 mb-3"x-data="{ selectedGroups: @entangle('selectedGroups') }">
                                <label for="idsGroup" class="form-label">IDS Group</label>
                                <div class="position-relative">
                                    <div class="custom-select"  x-data="{ open: false }">
                                        <div class="select-header form-select d-flex justify-content-between align-items-center "
                                        @click="open = !open">
                                            <span>{{ count($selectedGroups) ? count($selectedGroups) . ' Selected' : 'All Groups' }}</span>
                                        </div>

                                        
                                        <div x-show="open" 
                                        @click.outside="open = false" style="display: none;" class="select-dropdown shadow position-absolute w-100 bg-white rounded mt-1" style="z-index: 1000;">
                                            <div class="px-2 py-2">
                                                <input type="text" class="form-control" wire:model.live="searchGroup" placeholder="Search groups...">
                                            </div>

                                            <!-- Select All Checkbox -->
                                            <div class="select-option hover:bg-gray-100 p-2 border-bottom  ">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="selectAll"
                                                        wire:click="toggleAllGroups"
                                                        @click="$wire.$refresh()"
                                                        x-bind:checked="selectedGroups.length === {{ count($idsGroups) }}">
                                                    <label class="form-check-label" for="selectAll"> Select All </label>
                                                </div>
                                            </div>

                                            <div class="select-options max-h-60 overflow-y-auto">
                                                @foreach($idsGroups as $group)
                                                    @if(empty($searchGroup) || str_contains(strtolower($group->name), strtolower($searchGroup)))
                                                        <div class="select-option hover:bg-gray-100 p-2  ">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="group_{{ $loop->index }}"
                                                                    value="{{ $group}}"
                                                                    wire:click="toggleGroup('{{ $group }}')"
                                                                    @click="$wire.$refresh()"
                                                                    x-bind:checked="selectedGroups.includes('{{ $group }}')">
                                                                <label class="form-check-label" for="group_{{ $loop->index }}">
                                                                    {{ $group }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3" x-data="{ selectedUsers: @entangle('selectedUsers') }">
                                <label for="idsGroup" class="form-label">Users</label>
                                <div class="position-relative">
                                    <div class="custom-select" x-data="{ open: false }">
                                        <div @click="open = !open"  class="select-header form-select d-flex justify-content-between align-items-center  ">
                                            <span>{{ count($selectedUsers) ? count($selectedUsers) . ' Selected' : 'All Users' }}</span>
                                        </div>

                                       
                                        <div x-show="open" 
                                        @click.outside="open = false" style="display: none;" class="select-dropdown shadow position-absolute w-100 bg-white rounded mt-1" style="z-index: 1000;">
                                            <div class="px-2 py-2">
                                                <input type="text" class="form-control" wire:model.live="searchUser" placeholder="Search users...">
                                            </div>

                                            <!-- Select All Checkbox -->
                                            <div class="select-option hover:bg-gray-100 p-2 border-bottom">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="selectAllUsers"
                                                        wire:click="toggleAllUsers"
                                                        @click="$wire.$refresh()"
                                                        x-bind:checked="selectedUsers.length === {{ count($users) }}">
                                                    <label class="form-check-label" for="selectAllUsers"> Select All </label>
                                                </div>
                                            </div>

                                            <div class="select-options max-h-60 overflow-y-auto">
                                                @foreach($users as $user)
                                                    <div class="select-option hover:bg-gray-100 p-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="user_{{ $loop->index }}"
                                                                value="{{  $user['email']  }}"
                                                                wire:click="toggleUser('{{  $user['email'] }}')"
                                                                @click="$wire.$refresh()"
                                                                x-bind:checked="selectedUsers.includes('{{  $user['email']  }}')">
                                                            <label class="form-check-label" for="user_{{ $loop->index }}">
                                                                {{  $user['name']  }}
                                                            </label>
                                                        </div>
                                                    </div>
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


