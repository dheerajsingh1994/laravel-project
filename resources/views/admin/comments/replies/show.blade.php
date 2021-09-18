<x-admin-master>
    @section('content')
        <h2>Replies</h2>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header pt-3">
                {{-- <h6 class="m-0 font-weight-bold text-primary">Comments for : {{$post->title}}</h6> --}}
            </div>
            @if (count($replies))
            <div class="card-body">
                @if (session('msg'))
                    <div class="alert alert-success">{{session('msg')}}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Comment Author</th>
                                <th>Author Image</th>
                                <th>Email</th>
                                <th>Body</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($replies as $reply)
                            <tr>
                                <td>{{$reply->id}}</td>
                                <td>{{$reply->author}}</td>
                                <td>{{$reply->photo_id}}</td>
                                <td>{{$reply->email}}</td>
                                <td>{{$reply->body}}</td>
                                <td>
                                    @if ($reply->is_active == 1)
                                    <form action="{{route('replies.update', $reply->id)}}" method="POST">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="submit" value="Un-approve" class="btn btn-warning">
                                    </form>
                                    @else
                                    <form action="{{route('replies.update', $reply->id)}}" method="POST">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="is_active" value="1">
                                        <input type="submit" value="Approve" class="btn btn-primary">
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    {{-- @can('view',$reply) --}}
                                    <a href="{{route('replies.edit', $reply->id)}}"><i class="fa fa-edit"></i></a>
                                    <form action="{{route('replies.destroy', $reply->id)}}" method="post">
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
            <div class="text-center">
                No Replies!
            </div>   
            @endif
        </div>
        {{-- {{'Showing 1 of '. count($replies)}} --}}
        <div class="d-flex">
            <div class="mx-auto">
                {{-- {{$replies->links()}} --}}
            </div>
        </div>
    @endsection

    @section('allposts-scripts')
        <!-- Page level plugins -->
        <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

        <!-- Page level custom scripts -->
        <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
    @endsection
</x-admin-master>