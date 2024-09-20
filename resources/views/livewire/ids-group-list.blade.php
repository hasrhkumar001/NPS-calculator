<div>
    <h2>Groups List</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
                
                <td ><button class="btn btn-danger btn-sm shadow" wire:click="delete({{$group->id}})" wire:confirm="Are you sure you want to delete this? ">Delete</i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
