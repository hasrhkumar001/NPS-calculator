<html>
    <head>
        <style>
            .nav-link.active{
                    background-color:white !important;
                    color:#007DBD !important;
                }
        </style>
    </head>
    <body>
        <div class="d-flex flex-column sidebar flex-shrink-0 p-3 text-light min-vh-100" style="width: 250px; background-color: #007DBD; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); ">
            
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item ">
                            
                        </li>
                        
                        <!-- Survey Request -->
                        @if($role === 'user')
                         <!-- Dashboard -->
                         <li class="nav-item mb-2">
                            <a href="/user" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('user') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-tachometer-alt me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="/survey" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('survey') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;"
                            aria-current="page">
                                <i class="fa-solid fa-file-alt me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Send Survey
                            </a>
                        </li>

                       

                        <!-- Clients Status List -->
                        <li class="nav-item mb-2">
                            <a href="/survey-status" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('survey-status') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-users me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Survey Status 
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="{{ route('users.edit.user', auth()->user()->id) }}" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('user/edit/*') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-user-circle me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Profile
                            </a>
                        </li>
                        @elseif($role === 'admin')

                        <!-- Dashboard -->
                        <li class="nav-item mb-2">
                            <a href="/admin" wire:navigate  class="nav-link d-flex align-items-center {{ Request::is('admin') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-tachometer-alt me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="/survey" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('survey') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;"
                            aria-current="page">
                                <i class="fa-solid fa-file-alt me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Send Survey
                            </a>
                        </li>
                       
                        <li class="nav-item mb-2">
                            <a href="/users" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('users') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;"
                            aria-current="page">
                                <i class="fa-solid fa-users-cog me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                User List
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="/add-users" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('add-users') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-user-plus me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Add User
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="/ids-groups/create" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('ids-groups/create') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-users me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Add Group
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="/ids-groups" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('ids-groups') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-users me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Groups List
                            </a>
                        </li>

                        <!-- Clients Status List -->
                        <li class="nav-item mb-2">
                            <a href="/all-surveys-status" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('all-surveys-status') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-user-check me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Survey Status
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="{{ route('admins.edit', auth()->user()->id) }}" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('admin/edit/*') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-user-circle me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Profile
                            </a>
                        </li>
                        @elseif($role === 'subadmin')
                        <!-- Dashboard -->
                        
                        <li class="nav-item mb-2">
                            <a href="/subadmin"  class="nav-link d-flex align-items-center {{ Request::is('subadmin') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-tachometer-alt me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="/survey" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('survey') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;"
                            aria-current="page">
                                <i class="fa-solid fa-file-alt me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Send Survey
                            </a>
                        </li>
                        
                        <li class="nav-item mb-2">
                            <a href="/users-surveys-status" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('users-surveys-status') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-user-check me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Survey Status
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="{{ route('subadmin.edit', auth()->user()->id) }}" wire:navigate class="nav-link d-flex align-items-center {{ Request::is('subadmin/edit/*') ? 'active' : '' }}" 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-user-circle me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Profile
                            </a>
                        </li>
                        @endif
                        <li class="nav-item mb-2">
                            <a href="#" wire:click.prevent="logout" class="nav-link d-flex align-items-center " 
                            style="color: #fff; padding: 10px; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                <i class="fa-solid fa-sign-out-alt me-3" style="font-size: 18px;"></i> <!-- Updated icon -->
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </body>
