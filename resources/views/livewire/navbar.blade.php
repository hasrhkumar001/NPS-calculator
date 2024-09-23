<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Brand -->
        @if($role === 'admin')
        <a class="navbar-brand" href="/admin/dashboard">IDS InfoTech</a>
        
        @else
        <a class="navbar-brand" href="/dashboard">IDS InfoTech</a>
        @endif

        <!-- Toggle Button (for smaller screens) -->
        @if($role)
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Collapsible Content -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <!-- Settings Dropdown -->
               
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear"></i> <!-- Settings Icon -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                    @if($role === 'admin')
                        <li><a class="dropdown-item " wire:navigate href="/add-users">Add User</a></li>
                        <li><a class="dropdown-item" wire:navigate href="/users">User List</a></li>
                        <li><a class="dropdown-item" wire:navigate href="/ids-groups/create">Add Group</a></li>
                        <li><a class="dropdown-item" wire:navigate href="/ids-groups">Group List</a></li>
                        <li><hr class="dropdown-divider"></li>
                    @endif
                        <li><a class="dropdown-item" href="#" wire:click.prevent="logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
            
        </div>
        @endif
    </div>
</nav>
