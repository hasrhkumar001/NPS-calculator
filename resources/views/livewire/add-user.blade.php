

<div class="container my-3 mt-4">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    <div class="">
        <div class=" justify-content-baseline">
            <div class="row mb-3 ">
                <div class="col">
                    <h2>Add New User</h2>
                </div>
                <div class="col">
                    <a href="/users" wire:navigate class="btn btn-primary float-end">Users List</a>
                </div>
            </div>
        </div>
        <div class="">
            <form wire:submit.prevent="saveUser" enctype="multipart/form-data" autocomplete="off" novalidate>
                
                <!-- Role Selection -->
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="role" class="form-label fw-bold">Role</label>
                        <select id="role" wire:model="role"  class="form-select">
                            <option value="">Select Role</option>
                            <option value="3">Admin</option>
                            <option value="2">Sub Admin</option>
                            <option value="1">User</option>
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Custom Multiselect Dropdown -->
                    <div class="mb-3 col-6">
                    <label for="idsGroup" class="form-label fw-bold">IDS Group</label>
                    <div class="custom-multiselect">
                        <input type="text" placeholder="Select IDS Group" id="selectedGroups" style="height: 38px; border-radius: 5px;" class="form-select" onclick="toggleDropdown()" readonly>
                        <div id="dropdown" class="dropdown-options">
                            @foreach ($idsGroups as $group)
                                <div class="dropdown-item" onclick="toggleCheckbox('group_{{ $group->id }}')">
                                    <input type="checkbox" value="{{ $group->name }}" id="group_{{ $group->id }}" onclick="updateSelectedGroups(event)">
                                    <label for="group_{{ $group->id }}">{{ $group->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('idsGroup')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                </div>
                
                <div class="row">
                    <!-- Name Field -->
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input type="text" class="form-control" wire:model="name" id="name" placeholder="Enter Name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3 col-6">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" wire:model="email" id="email" placeholder="Enter Email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <!-- Conditional IDS Group Selection (disabled for 'admin' role) -->
                    
                    


                    
                </div>
                        
                <button type="submit" class="btn btn-success mt-3 px-3 ">Add</button>
            </form>
        </div>
    </div>
</div>




        <script>
            $(document).ready(function() {
                // Function to handle role change
                function handleRoleChange() {
                    var selectedRole = $('#role').val();
                    var $idsGroupInput = $('#selectedGroups');
                    var $idsGroupDropdown = $('#dropdown');

                    if (selectedRole == '3') { // Admin role
                        // Disable and style the input
                        $idsGroupInput.prop('disabled', true)
                                    .css('background-color', '#e9ecef')
                                    .val(''); // Clear the input

                        // Disable, uncheck, and style the checkboxes
                        $idsGroupDropdown.find('input[type="checkbox"]').each(function() {
                            $(this).prop('disabled', true)
                                .prop('checked', false)
                                .closest('.dropdown-item').css('background-color', '#e9ecef');
                        });

                        // Update the input to reflect no selections
                        updateSelectedGroups();
                    } else {
                        // Enable and remove styling from the input
                        $idsGroupInput.prop('disabled', false)
                                    .css('background-color', '');

                        // Enable and remove styling from the checkboxes
                        $idsGroupDropdown.find('input[type="checkbox"]').each(function() {
                            $(this).prop('disabled', false)
                                .closest('.dropdown-item').css('background-color', '');
                        });
                    }
                }

                // Function to update selected groups
                function updateSelectedGroups() {
                    var selectedGroups = [];
                    $('#dropdown input[type="checkbox"]:checked').each(function() {
                        selectedGroups.push($(this).val());
                    });
                    $('#selectedGroups').val(selectedGroups.join(', '));
                }

                // Initial call to set the correct state
                handleRoleChange();

                // Listen for changes on the role dropdown
                $('#role').on('change', handleRoleChange);

                // Listen for checkbox changes
                $('#dropdown').on('change', 'input[type="checkbox"]', updateSelectedGroups);

                // If you're using Livewire, you might need this additional listener
                document.addEventListener('livewire:load', function () {
                    Livewire.hook('message.processed', (message, component) => {
                        handleRoleChange();
                    });
                });
            });
        </script>
        <script>
            function toggleDropdown() {
                document.getElementById("dropdown").classList.toggle("show");
            }

            function updateSelectedGroups() {
                var checkboxes = document.querySelectorAll('.dropdown-item input[type="checkbox"]');
                var selected = [];
                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        selected.push(checkbox.value);
                    }
                });
                document.getElementById('selectedGroups').value = selected.join(', ');
                @this.set('idsGroup', selected);
               
            }

            function toggleCheckbox(checkboxId) {
                const checkbox = document.getElementById(checkboxId);
                checkbox.checked = !checkbox.checked;  // Toggle checkbox state
                updateSelectedGroups(checkbox);        // Update selected groups
            }

            document.getElementById('selectedGroups').addEventListener('input', function() {
                var filter = this.value.toUpperCase();
                var items = document.querySelectorAll('.dropdown-item label ');
                items.forEach(function(item) {
                    if (item.textContent.toUpperCase().indexOf(filter) > -1) {
                        item.parentElement.style.display = "";
                    } else {
                        item.parentElement.style.display = "none";
                    }
                });
            });

            window.onclick = function(event) {
                if (!event.target.matches('#selectedGroups')) {
                    var dropdowns = document.getElementsByClassName("dropdown-options");
                    for (var i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        // if (openDropdown.classList.contains('show')) {
                        //     openDropdown.classList.remove('show');
                        // }
                    }
                }
            }
        </script>