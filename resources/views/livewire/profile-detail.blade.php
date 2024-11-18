<!-- resources/views/livewire/profile-detail.blade.php -->
<div class="card">
    <div class="card-body">
        
        
        <!-- Avatar Section -->
        
<div class="row">
        <!-- Profile Information (Read-Only) -->
        <div class="d-flex justify-content-between">
                <h5 class="card-title  fw-bold mb-3">Profile Details</h5>
                
                <!-- Show "Edit" button based on user role -->
                @if($role === 'subadmin')
                    <a href="{{ route('subadmin.edit', auth()->user()->id) }}" class="btn btn-success float-end mx-2 addnewuser">Edit</a>
                @elseif($role === 'admin')
                    <a href="{{ route('admins.edit', auth()->user()->id) }}" class="btn btn-success float-end mx-2 addnewuser">Edit</a>
                @else
                    <a href="{{ route('users.edit.user', auth()->user()->id) }}" class="btn btn-success float-end mx-2 addnewuser">Edit</a>
                @endif
        </div>
        <div class="text-center mb-3 col-6 d-flex align-items-center justify-content-center">
            <!-- Default avatar icon (FontAwesome) if no image exists -->
            <i class="fas fa-user-circle" style="font-size: 150px; color: #ccc;"></i>
        </div>
        
        <div class="col-1">
      
                <div class="my-3 ">
                    <p for="name" class="form-label ">Name:</p>
                  
                </div>
                
                <div class="mb-3 ">
                    <p for="email" class="form-label ">Email:</p>
                    
                </div>

                <div class="mb-3 ">
                    <p for="role" class="form-label ">Role:</p>
                   
                </div>

                <div class="mb-3 ">
                    <p for="groups" class="">Groups:</p>
                    
                </div>
        </div>
        <div class="col-5">
      
                <div class="my-3 ">
                    
                    <p id="name" class=" form-label">{{ $name }}</p>
                </div>
                
                <div class="mb-3 ">
                    
                    <p id="email" class="form-label">{{ $email }}</p>
                </div>

                <div class="mb-3 ">
                    
                    <p id="role" class="form-label ">{{ $role }}</p>
                </div>

                <div class="mb-3 ">
                    
                    <p id="groups" class=" form-label">{{ is_array($groups) ? implode(', ', $groups) : $groups }}</p>
                </div>
        </div>
        
</div>

    </div>
</div>
