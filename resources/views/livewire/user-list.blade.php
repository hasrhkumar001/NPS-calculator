<div class="container my-3 mt-4">
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

    <div class="row justify-content-center">
        <div class="col">
            <h2>{{ ucfirst($selectedRole) }} List</h2>
        </div>
        <div class="col d-flex justify-content-end">
            <select wire:change="updateListBasedOnRole" wire:model="selectedRole" class="form-select me-2" style="width: 200px;">
                <option value="all">All</option>
                <option value="users">Users</option>
                <option value="admins">Admins</option>
                <option value="subadmins">Sub Admins</option>
            </select>
            <a href="/add-users" class="btn btn-success float-end mx-2">Add New User</a>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered my-3">
            <thead>
                <tr class="text-center">
                    <th scope="col">Serial No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col" colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($list as $item)
                    <tr class="text-center">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ ucfirst($item->role) }}</td>
                        <td>
                            @if($item->role == 'user')
                                <a href="{{ url('subadmin/user/' . $item->id . '/edit') }}" wire:navigate class="btn btn-primary btn-sm shadow mr-2">EDIT</a>
                                <button class="btn btn-danger btn-sm shadow" wire:click="delete({{ $item->id }})">DELETE</button>
                            @elseif($item->role == 'subadmin')
                                <a href="{{ route('subadmin.edit', $item->id) }}" wire:navigate class="btn btn-primary btn-sm shadow mr-2">EDIT</a>
                                <button class="btn btn-danger btn-sm shadow" wire:click="deleteSubAdmin({{ $item->id }})">DELETE</button>
                            @elseif($item->role == 'admin')
                                <a href="{{ route('admins.edit', $item->id) }}" wire:navigate class="btn btn-primary btn-sm shadow mr-2">EDIT</a>
                                <button class="btn btn-danger btn-sm shadow" wire:click="deleteAdmin({{ $item->id }})">DELETE</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>