<x-admin-master>
    @section('content')
        <h2>Comments</h2>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header pt-3">
                {{-- <h6 class="m-0 font-weight-bold text-primary">Comments for : {{$post->title}}</h6> --}}
            </div>
            @if (count($comments))
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
                                <th>Post</th>
                                <th>Comments</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                            <tr>
                                <td>{{$comment->id}}</td>
                                <td>{{$comment->author}}</td>
                                <td>{{$comment->photo_id}}</td>
                                <td>{{$comment->email}}</td>
                                <td>{{$comment->body}}</td>
                                <td>
                                    <a href="{{route('post', $comment->post->id)}}" target="_blank">View Post</a>
                                </td>
                                <td>
                                    @if (count($comment->replies) > 0)
                                    <a href="{{route('replies.show', $comment->id)}}">View Replies</a>
                                    @else
                                    {{"No replies"}}
                                    @endif
                                </td>
                                <td>
                                    @if ($comment->is_active == 1)
                                    <form action="{{route('comments.update', $comment->id)}}" method="POST">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="submit" value="Un-approve" class="btn btn-warning">
                                    </form>
                                    @else
                                    <form action="{{route('comments.update', $comment->id)}}" method="POST">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="is_active" value="1">
                                        <input type="submit" value="Approve" class="btn btn-primary">
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    {{-- @can('view',$comment) --}}
                                    <a href="{{route('comments.edit', $comment->id)}}"><i class="fa fa-edit"></i></a>
                                    <form action="{{route('comments.destroy', $comment->id)}}" method="post">
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
                
            @endif
        </div>
        {{-- {{'Showing 1 of '. count($comments)}} --}}
        <div class="d-flex">
            <div class="mx-auto">
                {{-- {{$comments->links()}} --}}
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