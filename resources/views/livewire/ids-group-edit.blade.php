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
    <h2 class="mb-4">Edit Group Name</h2>
    <form wire:submit.prevent="submit">
        <div class="form-group mb-3">
            <label for="name" class="form-label">Group Name</label>
            <input type="text" wire:model="name" class="form-control" id="name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

       

        <button type="submit" class="btn btn-primary">Update Group</button>
    </form>
</div>
