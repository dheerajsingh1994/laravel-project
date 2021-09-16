<x-admin-master>
    @section('content')
        <h2>Manage Users</h2>
        @if(session('userdel-msg'))
          <div class="alert alert-danger">{{session('userdel-msg')}}</div>
          <!--another flash message method -->
        @elseif(Session::has('useradd-msg'))
          <div class="alert alert-success">{{Session::get('useradd-msg')}}</div>
        @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header pt-3">
              <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            </div>
            {{-- {{dd($users)}} --}}
            @if($users)
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>Role</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Registered Date</th>
                      <th>Update Date</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>Role</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Registered Date</th>
                      <th>Update Date</th>
                      <th>Options</th>
                    </tr>
                  </tfoot>
                  <tbody>
                      @foreach ($users as $user)
                        <tr>
                          <td>{{$user->id}}</td>
                          <td>
                            <a href="{{route('user.profile.show', $user->id)}}">{{$user->username}}</a>
                          </td>
                          <td>
                            @foreach ($user->roles as $role)
                                {{$role->name}}
                            @endforeach
                          </td>
                          <td>
                            @if($user->avatar)
                            <img src="{{$user->avatar}}" height="40px"></td>
                            @else
                              {{'No Image Uploaded'}}
                            @endif
                          <td>{{$user->name}}</td>
                          <td>{{$user->created_at->diffForhumans()}}</td>
                          <td>{{$user->updated_at->diffForhumans()}}</td>
                            <td>
                              {{-- @can('view',$user) --}}
                            {{-- <a href="{{route('post.edit', $user->id)}}"><i class="fa fa-edit"></i></a> --}}
                            <form action="{{route('user.delete', $user->id)}}" method="post" enctype="multipart/form">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">
                                <i type="submit" class="fa fa-trash"></i>
                              </button>
                            </form>
                            {{-- @endcan --}}
                            {{-- hides buttons --}}
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            @else
              <div class="card-body">
                <h4>No Users!</h4>
                <div class="pull-right">
                  <span>Add your first user</span>
                  {{-- <a href="{{route('user.create')}}"> --}}
                    <button class="btn btn-primary pull-right">Add User !</button>
                  {{-- </a> --}}
                </div>
              </div>
            @endif
          </div>
          {{-- {{'Showing 1 of '. count($users)}} --}}
          {{-- <div class="d-flex">
            <div class="mx-auto">
              {{$users->links()}}
            </div>
          </div> --}}
    @endsection

    @section('allposts-scripts')
        <!-- Page level plugins -->
        <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

        <!-- Page level custom scripts -->
        <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
    @endsection
</x-admin-master>