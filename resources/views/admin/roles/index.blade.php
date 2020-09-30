<x-admin-master>
    @section('content')
        <h2>Manage Roles</h2>
        
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
          </div>
          <div class="row">
            @if(session('added-msg'))
              <div class="alert alert-success">{{session('added-msg')}}</div>
            @elseif(session('updated-msg'))
              <div class="alert alert-success">{{session('updated-msg')}}</div>
            @elseif(session('deleted-msg'))
              <div class="alert alert-danger">{{session('deleted-msg')}}</div>
            @endif
            <div class="col-md-6 ml-3 mt-3">
              @if(($roleEdit))
              <form action="{{route('role.update', $roleEdit->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="update Role">Update Role</label>
                  <input class="form-control" type="text" id="role" name="role" value="{{$roleEdit->name}}">
                  <div id="role-length"></div>
                </div>
                <button type="submit" id="submit-btn" class="btn btn-warning">Update Role</button>
                <a href="{{route('roles.index')}}">
                  <button type="button" class="btn btn-dark">Cancel</button>
                </a>
              </form>
              @else
              <form action="{{route('role.create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="role">Add Role</label>
                  <input class="form-control" type="text" id="role" name="role">
                  <div id="role-length"></div>
                </div>
                <button type="submit" id="submit-btn" class="btn btn-primary">Add Role</button>
              </form>
              @endif
            </div>
          </div>

          @if(($roles))
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Edit Role</th>
                    <th>Update Role</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Edit Role</th>
                    <th>Update Role</th>
                  </tr>
                </tfoot>
                <tbody>
                    @foreach ($roles as $role)
                      <tr>
                        <td>{{$role->id}}</td>
                        <td>
                          <a href="{{route('role.edit', $role->id)}}">{{$role->name}}</a>
                        </td>
                        <td>{{$role->slug}}</td>
                        <td>{{$role->created_at->diffForhumans()}}</td>
                        <td>{{$role->updated_at->diffForhumans()}}</td>
                        <td>
                          {{-- @can('view',$role) --}}
                          <a href="{{route('role.quickedit', $role->id)}}"><button class="btn btn-primary">Quick Edit</button></a>
                          {{-- @endcan --}}
                          {{-- hides buttons --}}
                        </td>
                        <td>
                          <form action="{{route('role.delete', $role->id)}}" method="post" enctype="multipart/form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @else
            <div class="card-body">
              <h4>No Roles!</h4>
              <div class="pull-right">
                <span>Add Role</span>
                <a href="{{route('role.create')}}">
                  <button class="btn btn-primary pull-right">Write Post !</button>
                </a>
              </div>
            </div>
          @endif
        </div>
        {{-- {{'Showing 1 of '. count($roles)}} --}}
        {{-- <div class="d-flex">
          <div class="mx-auto">
            {{$roles->links()}}
          </div>
        </div> --}}

        <script>
          $roleName = document.getElementById('role');
          $submitBtn = document.getElementById('submit-btn');

          // On load
          document.addEventListener('DOMContentLoaded', function(){            
            if($roleName.value.length < 3){
              $submitBtn.setAttribute("disabled", "");
            }
          });

          // on input
          document.addEventListener('input', function(){
            $roleLength = document.getElementById('role-length');

            if($roleName.value.length < 3){
              $submitBtn.setAttribute("disabled", "");
              $roleLength.innerHTML = 'Role name should be greater than 2 characters';
              $roleLength.className = 'invalid-feedback';
            } else {
              $submitBtn.removeAttribute('disabled');
            }
          });
        </script>
  @endsection

  @section('allposts-scripts')
    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
  @endsection
</x-admin-master>