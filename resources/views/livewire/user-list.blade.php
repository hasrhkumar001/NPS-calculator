<div class="container my-3">
  @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header justify-content-baseline">
            <div class="row">
           <div class="col"><h2>Users List</h2></div>
           <div class="col">
           
           <a href="/add-users" wire:navigate  class=" btn btn-success float-end mx-2">Add New User</a>
           
</div>
</div>
        </div>
        <div class="card-body ">
        <table class="table table-hover">
  <thead>
    <tr class="text-center">
      <th scope="col">Serial No.</th>
      <th scope="col">User Name</th>
      <th scope="col">Email</th>
      
      
      <th scope="col" colspan="2">Actions</th>
    </tr>
  </thead>
  <tbody>
      @foreach($users as $item)
    <tr class="text-center">
      <th scope="row">{{$loop->iteration}}</th>
      
      <td >{{$item->name}}</td>
      <td >{{$item->email}}</td>
      
      
      
      <td ><button class="btn btn-danger btn-sm shadow" wire:click="delete({{$item->id}})" wire:confirm="Are you sure you want to delete this? ">DELETE</button></td>
    </tr>
    @endforeach
    
  </tbody>
</table>
        </div>
    </div>

</div>
