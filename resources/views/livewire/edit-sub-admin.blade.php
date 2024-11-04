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
    <h2 class="mb-4">Edit Sub Admin</h2>
    <form wire:submit.prevent="updateAdmin">
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
                        <input type="text" value="{{ implode(', ', $idsGroup) }}"  placeholder="Select IDS Group" id="selectedGroups" style="height: 38px;border-radius: 5px;" class="form-select" onclick="toggleDropdown()" readonly>
                        <div id="dropdown" class="dropdown-options">
                            @foreach ($idsGroups as $group)
                                <div class="dropdown-item" >
                                    <input type="checkbox" value="{{ $group->name }}" id="group_{{ $group->id }}" 
                                        @if(in_array($group->name, $idsGroup)) checked @endif 
                                        onclick="updateSelectedGroups(this)">
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

        <button type="submit" class="btn btn-primary">Update Admin</button>
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

function toggleCheckbox(event) {
    // Prevent the event from bubbling up to parent elements
    event.stopPropagation();
    
    // Find the checkbox within the clicked row
    const checkbox = event.currentTarget.querySelector('input[type="checkbox"]');
    
    // Toggle the checkbox
    checkbox.checked = !checkbox.checked;
    
    // Update selected groups
    updateSelectedGroups();
}

document.addEventListener('DOMContentLoaded', function() {
    // Add click event listeners to all dropdown items
    const dropdownItems = document.querySelectorAll('.dropdown-item label');
    dropdownItems.forEach(item => {
        item.addEventListener('click', toggleCheckbox);
    });

    // Prevent checkbox click from triggering the row click event twice
    const checkboxes = document.querySelectorAll('.dropdown-item input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function(event) {
            event.stopPropagation();
            updateSelectedGroups();
        });
    });

    // Add input event listener for filtering
    document.getElementById('selectedGroups').addEventListener('input', function() {
        var filter = this.value.toUpperCase();
        var items = document.querySelectorAll('.dropdown-item label');
        items.forEach(function(item) {
            if (item.textContent.toUpperCase().indexOf(filter) > -1) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });

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

    // Open dropdown when clicking on the input
    document.getElementById('selectedGroups').addEventListener('click', function(event) {
        event.stopPropagation();
        document.getElementById('dropdown').classList.add('show');
    });
});
</script>
