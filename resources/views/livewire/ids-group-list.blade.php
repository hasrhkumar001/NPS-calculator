<div class="container">
    <div class="mb-3  mt-5">
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
    <h2>Groups List</h2>
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>Sr No.</th>
                <th>Name</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr class="text-center">
                <td>{{$loop->iteration}}</td>
                <td>{{ $group->name }}</td>
                
                <td ><a href="{{ route('ids-group.edit', $group->id) }}" wire:navigate class="btn btn-primary btn-sm shadow  px-3 mx-3">EDIT</a>
                    <button class="btn btn-danger btn-sm shadow mx-3 px-3" wire:click="delete({{$group->id}})" wire:confirm="Are you sure you want to delete this? ">Delete</i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <dov>
</div>
