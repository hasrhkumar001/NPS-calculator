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
        <div class="form-group mb-3">
                <label for="idsGroup" class="form-label">IDS Group</label>
                <select wire:model="idsGroup" id="idsGroup" class="form-select">
                    <option value="">All Groups</option>
                    @foreach($idsGroups as $group)
                        <option value="{{ $group->name }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
