<div class="container-fluid">
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
    
    <div class="row justify-content-center">
        <div class="col">
            <h2>Groups List</h2>
        </div>
        <div class="col d-flex justify-content-end">
            <!-- <input type="text" class="form-control me-2" placeholder="Search " wire:model="search" wire:keydown.enter="searchGroup"  style="width: 200px;">
             -->
             <input type="text" 
           wire:model.live.debounce.300ms="search" 
           wire:keydown.enter="searchGroup" 
           class="form-control" 
           placeholder="Search groups..." 
           style="width: 300px;">
            <a href="/ids-groups/create" class="btn btn-success float-end mx-2 addnewgroupbtn">Add New Group</a>
        </div>
    </div>
    <table class="table table-bordered my-3 ">
        <thead>
            <tr class="text-center">
                <th>Sr No.</th>
                <th>Name</th>
                <th>Questions</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr class="text-center">
                <td>{{$loop->iteration}}</td>
                <td>{{ $group->name }}</td>
                <td><a href="{{ route('group.questions', $group->id) }}" wire:navigate class="btn btn-success btn-sm shadow editdeletebtn  px-3 mx-3">Questions</a></td>
                <td ><a href="{{ route('ids-group.edit', $group->id) }}" wire:navigate class="btn btn-primary btn-sm shadow editdeletebtn  px-3 mx-3">EDIT</a>
                    <button class="btn btn-danger btn-sm shadow editdeletebtn mx-3 px-3" wire:click="delete({{$group->id}})" wire:confirm="Are you sure you want to delete this? ">DELETE</i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <dov>
</div>
