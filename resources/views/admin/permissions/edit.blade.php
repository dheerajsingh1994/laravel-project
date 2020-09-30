<x-admin-master>
    @section('content')
    <div class="row">
        <div class="col-md-6 col-sm-3 col xs-3 mb-3">
            <h2>Edit Permission : {{$permission->name}}</h2>
            <form action="{{route('permission.update', $permission->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="Permission">Permission</label>
                    <input class="form-control" type="text" id="permission" name="permission" value="{{$permission->name}}">
                    <div id="permission-length"></div>
                </div>
                <button type="submit" id="submit-btn" class="btn btn-warning">Update Permission</button>
                <a href="{{route('permissions.index')}}">
                    <button type="button" class="btn btn-dark">Cancel</button>
                </a>
            </form>
        </div>    
    </div>

    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Permissions</h6>
                </div>
            </div>
        </div>
    </div> --}}
    @endsection
</x-admin-master>