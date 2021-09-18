<x-admin-master>
    @section('content')
        <h1>User Profile: {{$user->name}}</h1>
        <div class="row">
            <div class="col-sm-6 mb-3">
                <form action="{{route('user.profile.update', $user)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <div class="mb-4">
                            <img class="img-profile rounded"
                            style="height: 100px;"
                            src="{{asset($user->avatar)}}">
                        </div>
                        <input type="file" name="profile_image" id="profile_image">
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input
                        class="form-control
                        @error('username')
                            {{'is-invalid'}}
                        @enderror
                        " type="text"
                        name="username"
                        value="{{$user->username}}">
                        @error('username')
                        <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input
                        class="form-control
                        {{$errors->has('name') ?'is-invalid' : ''}}" type="text"
                        name="name"
                        value="{{$user->name}}">
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input
                        class="form-control
                        {{$errors->has('email') ?'is-invalid' : ''}}" type="email"
                        name="email"
                        value="{{$user->email}}">
                        @error('email')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                        class="form-control" type="password"
                        name="password">
                        @error('password')
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input
                        class="form-control" type="password"
                        name="password-confirm">
                        @error('password-confirm')
                            {{$message}}
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        @if(auth()->user()->userHasRole('admin'))
        <div class="card shadow mb-4">
            <div class="col-sm-12">
                <div class="card-header pt-3">
                    <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
                </div>
                @if(session('userattach-msg'))
                    <div class="alert alert-success">{{session('userattach-msg')}}</div>
                @elseif(Session::has('userdetach-msg'))
                    <div class="alert alert-danger">{{Session::get('userdetach-msg')}}</div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered" id="rolesTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Select</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Attach</th>
                            <th>Detach</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Select</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Attach</th>
                            <th>Detach</th>
                          </tr>
                        </tfoot>
                        <tbody>
                            {{-- {{dd($user->roles, $roles)}} --}}
                            @foreach ($roles as $role)
                              <tr>
                                <td>
                                    <input
                                    type="checkbox"
                                    name="user-role[]"
                                    @foreach($user->roles as $user_role)
                                        @if($user_role->slug == $role->slug)
                                            checked
                                        @endif
                                    @endforeach
                                    @if(!$user->roles->contains($role))
                                        disabled
                                    @endif
                                    >
                                </td>
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td>{{$role->slug}}</td>
                                <td>
                                    <form action="{{route('user.role.attach', $user->id)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-primary" type="submit"
                                            @if($user->roles->contains($role))
                                                disabled
                                            @endif
                                        >Attach</button>
                                        <input type="hidden" name="role" value="{{$role->id}}">
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route('user.role.detach', $user->id)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-danger" type="submit"
                                            @if(!$user->roles->contains($role))
                                                disabled
                                            @endif
                                        >Detach</button>
                                        <input type="hidden" name="role" value="{{$role->id}}">
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
        @endif
    @endsection
</x-admin-master>