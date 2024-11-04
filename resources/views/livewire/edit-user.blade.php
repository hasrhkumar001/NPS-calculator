<div class="container mt-4">
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
    <h2 class="mb-4">Edit User</h2>
    <form wire:submit.prevent="updateUser">
        <div class="form-group mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" class="form-control" wire:model="name">
            @error('name') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" class="form-control" wire:model="email">
            @error('email') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password" class="form-label">New Password (leave blank to keep current)</label>
            <input type="password" id="password" class="form-control" wire:model="password">
            @error('password') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        @if(auth()->user()->role == 3) 
        <div class="mb-3 col-12">
            <label for="idsGroup" class="form-label fw-bold">IDS Group</label>
            <div class="custom-multiselect">
                <input type="text" value="{{ implode(', ', $idsGroup) }}" placeholder="Select IDS Group" id="selectedGroups" style="height: 38px;border-radius: 5px;" class="form-select" onclick="toggleDropdown()" readonly>
                <div id="dropdown" class="dropdown-options">
                    @foreach ($idsGroups as $group)
                        <!-- Make entire row clickable -->
                        <div class="dropdown-item" onclick="toggleCheckbox(event, '{{ $group->name }}')">
                            <input type="checkbox" value="{{ $group->name }}" id="group_{{ $group->id }}" 
                                @if(in_array($group->name, $idsGroup)) checked @endif>
                            <label for="group_{{ $group->id }}">{{ $group->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            @error('idsGroup')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        @endif
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>


<script>
function toggleDropdown() {
    document.getElementById("dropdown").classList.toggle("show");
}

function updateSelectedGroups() {
    var selected = [];
    var checkboxes = document.querySelectorAll('.dropdown-item input[type="checkbox"]');
    checkboxes.forEach(function(item) {
        if (item.checked) {
            selected.push(item.value);
        }
    });
    document.getElementById('selectedGroups').value = selected.join(', ');
    @this.set('idsGroup', selected);
}

// Updated toggleCheckbox to handle checkbox toggling via row click
function toggleCheckbox(event, value) {
    event.stopPropagation();
    
    // Find checkbox based on value passed
    const checkbox = event.currentTarget.querySelector('input[type="checkbox"]');
    
    // Toggle checkbox checked status
    checkbox.checked = !checkbox.checked;
    
    // Update selected groups after toggling
    updateSelectedGroups();
}

document.addEventListener('DOMContentLoaded', function() {
    // Prevent closing dropdown when clicking inside it
    document.getElementById('dropdown').addEventListener('click', function(event) {
        event.stopPropagation();
    });

    // Close dropdown only when clicking outside the dropdown and the input
    document.addEventListener('click', function(event) {
        var dropdown = document.getElementById('dropdown');
        var input = document.getElementById('selectedGroups');
        if (!dropdown.contains(event.target) && event.target !== input) {
            dropdown.classList.remove('show');
        }
    });
});
</script>
