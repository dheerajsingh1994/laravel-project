<x-admin-master>
    @section('content')
        <h2>Manage Permissions</h2>
        
        @if(session('permission-added'))
          <div class="alert alert-success">{!!session('permission-added')!!}</div>
        @elseif(session('permission-update'))
          <div class="alert alert-success">{!!session('permission-update')!!}</div>
        @elseif(session('permission-delete'))
          <div class="alert alert-danger">{!!session('permission-delete')!!}</div>
        @endif

        <div class="row">
          <div class="col-md-6 mb-3">
            @if($permissionEdit)
              <form action="{{route('permission.update', $permissionEdit->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="Edit Permission">Edit Permission</label>
                  <input class="form-control" type="text" id="permission" name="permission" value="{{$permissionEdit->name}}">
                </div>
                <div id="permission-length"></div>
                <button type="submit" id="submit-btn" class="btn btn-warning">Update Permission</button>
                <a href="{{route('permissions.index')}}">
                  <button type="submit" class="btn btn-dark">Cancel</button>
                </a>
              </form>
            @else
              <form action="{{route('permission.create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="Permission">Permission</label>
                  <input class="form-control" type="text" id="permission" name="permission">
                </div>
                <div id="permission-length"></div>
                <button type="submit" id="submit-btn" class="btn btn-primary">Add Permission</button>
              </form>
            @endif
          </div>
        </div>
        
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permissions</h6>
          </div>
          @if(($permissions))
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
                    @foreach ($permissions as $permission)
                      <tr>
                        <td>{{$permission->id}}</td>
                        <td><a href="{{route('permission.edit', $permission->id)}}">{{$permission->name}}</a></td>
                        <td>{{$permission->slug}}</td>
                        <td>{{$permission->created_at->diffForhumans()}}</td>
                        <td>{{$permission->updated_at->diffForhumans()}}</td>
                        <td>
                          {{-- @can('view',$permission) --}}
                          <a href="{{route('permission.quickedit', $permission->id)}}"><button class="btn btn-primary">Quick Edit</button></a>
                          {{-- @endcan --}}
                          {{-- hides buttons --}}
                        </td>
                        <td>
                          <form action="{{route('permission.delete', $permission->id)}}" method="post" enctype="multipart/form">
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
              <h4>No Permissions!</h4>
              <div class="pull-right">
                <span>Start adding permission for your roles</span>
                <form action="" method="post"></form>
                  <a href="{{route('permission.create')}}">
                  <button class="btn btn-primary pull-right">Add Permission !</button>
                </a>
              </div>
            </div>
          @endif
        </div>

        {{-- Validations --}}
        <script>
          $permissionName = document.getElementById('permission');
          $submitBtn = document.getElementById('submit-btn');

          // On load
          document.addEventListener('DOMContentLoaded', function(){            
            if($permissionName.value.length < 3){
              $submitBtn.setAttribute("disabled", "");
            }
          });

          // on input
          document.addEventListener('input', function(){
            $permissionLength = document.getElementById('permission-length');

            if($permissionName.value.length < 3){
              $submitBtn.setAttribute("disabled", "");
              $permissionLength.innerHTML = 'permission name should be greater than 2 characters';
              $permissionLength.className = 'invalid-feedback';
            } else {
              $submitBtn.removeAttribute('disabled');
            }
          });
        </script>
        {{-- VAlidations Ends --}}

  @endsection

  @section('allposts-scripts')
    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
  @endsection
</x-admin-master>