<div class="container">
    <div class="mb-3  mt-5">
    <h2>Groups List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Name</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $group->name }}</td>
                
                <td ><a href="{{ route('ids-group.edit', $group->id) }}" wire:navigate class="btn btn-primary btn-sm shadow mr-2">EDIT</a>
                    <button class="btn btn-danger btn-sm shadow" wire:click="delete({{$group->id}})" wire:confirm="Are you sure you want to delete this? ">Delete</i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <dov>
</div>
