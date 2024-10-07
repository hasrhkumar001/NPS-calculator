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

        <div class="mb-3 form-group">
                        <label for="idsGroup" class="form-label fw-bold">IDS Group</label>
                        <select id="idsGroup" class="form-control selectpicker" data-actions-box="true" required wire:model="idsGroup" multiple data-live-search="true" >
                            @foreach ($idsGroups as $group)
                                <option value="{{ $group->name }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        @error('idsGroup')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Admin</button>
    </form>
</div>


<script>
 
  
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });

</script>