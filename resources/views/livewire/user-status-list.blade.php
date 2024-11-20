<div class="container-fluid my-4">
    <div class="container-fluid my-4 bg-light shadow">
        <form wire:submit.prevent="filter">
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
                                        @if(empty($searchGroup) || str_contains(strtolower($group->name), strtolower($searchGroup)))
                                            <div class="select-option hover:bg-gray-100 cursor-pointer p-2" 
                                                 wire:click="selectGroup('{{ $group->name }}')"
                                                 @click="open = false">
                                                {{ $group->name }}
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
            </div>
        </form>
        </div>

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
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersubmissions as $submission)
                        <tr class="text-center {{ $submission->status === 'Pending' ? 'table-danger' : '' }}">
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $submission->idsGroup }}</td>
                            <td>{{ $submission->projectName }}</td>
                            <td>
                                @php
                                    $leadManager = \App\Models\Users::find($submission->user_id);
                                @endphp
                                {{ $submission->idsLeadManager }} 
                                ({{ $leadManager ? $leadManager->email : 'Deleted User' }})
                            </td>
                            <td>{{ $submission->clientContactName }}</td>
                            <td>{{ $submission->clientOrganization }}</td>
                            <td class="text-break" style="max-width: 200px;">
                                {{ $submission->clientEmailAddress }}
                            </td>
                            <td>{{ $submission->status }}</td>
                            <td>{{ $submission->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
</div>