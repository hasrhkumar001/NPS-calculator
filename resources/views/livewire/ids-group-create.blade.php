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
    <form wire:submit.prevent="submit">
            <div class="row mb-3 ">
                <div class="col">
                    <h2>Add New Group</h2>
                </div>
                
            </div>
        <div class="form-group mb-3 ">
            <label for="name"  class="form-label fw-bold">Group Name</label>
            <input type="text" wire:model="name" class="form-control" placeholder="Enter Group Name" id="name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
