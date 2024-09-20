<div>
    <form wire:submit.prevent="submit">
        <div class="form-group">
            <label for="name">Group Name</label>
            <input type="text" wire:model="name" class="form-control" id="name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        

        <button type="submit" class="btn btn-primary">Create Group</button>
    </form>
</div>
