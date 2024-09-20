<div class="container my-3">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header justify-content-baseline">
            <div class="row">
                <div class="col">
                    <h2>Add New User</h2>
                </div>
                <div class="col">
                    <a href="/users" wire:navigate class="btn btn-primary float-end">Users List</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveUser" enctype="multipart/form-data">
                
                <!-- Role Selection -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" wire:model="role"  class="form-select">
                        <option value="">Select Role</option>
                        <option value="1">Admin</option>
                        <option value="0">User</option>
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" wire:model="name" id="name" placeholder="Enter Name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" wire:model="email" id="email" placeholder="Enter Email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Conditional IDS Group Selection (disabled for 'admin' role) -->
                <div class="mb-3">
                    <label for="idsGroup" class="form-label">IDS Group</label>
                    <select id="idsGroup" class="form-select">
                        <option value="">Select IDS Group</option>
                        @foreach ($idsGroups as $group)
                            <option value="{{ $group->name }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                    @error('idsGroup')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" wire:model="password" id="password" placeholder="Enter Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                        
                <button type="submit" class="btn btn-success mt-3 float-end">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#role').change(function() {
            var selectedRole = $(this).val();
            if (selectedRole === 'admin') {
                $('#idsGroup').prop('disabled', true);
            } else {
                $('#idsGroup').prop('disabled', false);
            }
        });
    });
</script>
