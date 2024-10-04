<div class="container w-50 mt-5">
<div class="card shadow">
        <div class="card-header text-center fs-3 fw-bold" style="background-color: #2d4575; color: white">
            User Login 
        </div>
        <div class="card-body">

    <!-- Error Message for Invalid Credentials -->
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Login Form -->
    <form wire:submit.prevent="login"  >
    @csrf
    
        <!-- Email Input -->
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" wire:model="email" id="email" >
            @error('email') 
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password Input -->
        <div class="form-group mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" wire:model="password" id="password" >
            @error('password') 
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary mt-2 fw-bold p-3 w-100">Login</button>
    </form>
</div>
</div>
</div>
