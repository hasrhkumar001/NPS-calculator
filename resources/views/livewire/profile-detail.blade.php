<!-- resources/views/livewire/profile-detail.blade.php -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Profile Details</h5>
        
        <!-- Avatar Section -->
        <div class="text-center mb-3">
            <!-- Default avatar icon (FontAwesome) if no image exists -->
            <i class="fas fa-user-circle" style="font-size: 150px; color: #ccc;"></i>
        </div>
        
        

        <!-- Profile Form (Read-Only) -->
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" wire:model="name" disabled>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" wire:model="email" disabled>
            </div>
        </form>

        <!-- Show "Change Password" button based on user role -->
        @if($role === 'subadmin')
            <a href="{{ route('subadmin.edit', auth()->user()->id) }}" class="btn btn-success float-end mx-2 addnewuser">Change Password</a>
        @elseif($role === 'admin')
            <a href="{{ route('admins.edit', auth()->user()->id) }}" class="btn btn-success float-end mx-2 addnewuser">Change Password</a>
        @else
            <a href="{{ route('users.edit.user', auth()->user()->id) }}" class="btn btn-success float-end mx-2 addnewuser">Change Password</a>
        @endif
    </div>
</div>
