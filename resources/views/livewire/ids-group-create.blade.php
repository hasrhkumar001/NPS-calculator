<div class="container">
    <form wire:submit.prevent="submit">
        <div class="form-group mb-3  mt-5">
            <label for="name"  class="form-label">Group Name</label>
            <input type="text" wire:model="name" class="form-control" id="name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        

        <button type="submit" class="btn btn-primary">Create Group</button>
    </form>
</div>
