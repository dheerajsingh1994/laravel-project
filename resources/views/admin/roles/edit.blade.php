<x-admin-master>
    @section('content')
        <div class="row">
            <div class="col-md-6 col-sm-3 col xs-3 mb-3">
                <h1>Edit Role : {{$role->name}}</h1>
                <form action="{{route('role.update', $role->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="Role">Role</label>
                        <input class="form-control" type="text" id="role" name="role" value="{{$role->name}}">
                        <div id="role-length"></div>
                    </div>
                    <button type="submit" id="submit-btn" class="btn btn-warning">Update Role</button>
                    <a href="{{route('roles.index')}}">
                        <button type="button" class="btn btn-dark">Cancel</button>
                    </a>
                </form>
            </div>    
        </div>

        @if(($permissions))
            @if(session('attached'))
                <div class="alert alert-success">{!!session('attached')!!}</div>
            @elseif(session('detached'))
                <div class="alert alert-danger">{!!session('detached')!!}</div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Permissions</h6>
                        </div>
        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Options</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Attach</th>
                                        <th>Detach</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Options</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Attach</th>
                                        <th>Detach</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($permissions as $permission)
                                        <tr>
                                            <td>
                                                <input
                                                type="checkbox"
                                                @foreach($role->permissions as $role_permission)
                                                    @if($role_permission->id == $permission->id)
                                                        checked
                                                    @endif
                                                @endforeach
                                                @if(!$role->permissions->contains($permission))
                                                    disabled
                                                @endif
                                                >
                                            </td>
                                            <td>{{$permission->id}}</td>
                                            <td>{{$permission->name}}</td>
                                            <td>{{$permission->slug}}</td>
                                            <td>
                                                <form action="{{route('role.permission.attach', $role->id)}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="permission" value="{{$permission->id}}">
                                                    <input type="hidden" name="permission_name" value="{{$permission->name}}">
                                                    <button
                                                    type="submit"
                                                    class="btn btn-info"
                                                    @if($role->permissions->contains($permission))
                                                        disabled
                                                    @endif
                                                    >Attach</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{route('role.permission.detach', $role->id)}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="permission" value="{{$permission->id}}">
                                                    <input type="hidden" name="permission_name" value="{{$permission->name}}">
                                                    <button
                                                    type="submit"
                                                    class="btn btn-danger"
                                                    @if(!$role->permissions->contains($permission))
                                                        disabled
                                                    @endif
                                                    >Detach</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endsection
</x-admin-master>