<x-admin-master>
    @section('content')
        <h2>Manage Posts</h2>
        @if(session('postdel-msg'))
          <div class="alert alert-danger">{{session('postdel-msg')}}</div>
          {{-- another flash message method --}}
        @elseif(Session::has('postadd-msg'))
          <div class="alert alert-success">{{Session::get('postadd-msg')}}</div>
        @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Posts</h6>
            </div>
            @if(($posts))
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Image</th>
                      <th>Author</th>
                      <th>Category</th>
                      <th>Created at</th>
                      <th>Comments</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- {{dd($posts)}} --}}
                      @foreach ($posts as $post)
                        <tr>
                          <td>{{$post->id}}</td>
                          <td>{{$post->title}}</td>
                          <td>
                            @if($post->post_image != '')
                            <img src="{{asset($post->post_image)}}" alt="{{$post->title}}" title="{{$post->title}}" height="40px">
                            @else
                              {{'No Image Uploaded'}}
                            @endif
                          </td>
                          <td>{{$post->user->name}}</td>
                          <td>{{$post->category->title}}</td>
                          <td>{{$post->created_at->diffForHumans()}}</td>
                          <td>
                            <a href="{{route('comments.show', $post->id)}}">View Comments</a>
                          </td>
                          <td>
                            {{-- @can('view',$post) --}}
                            <a href="{{route('post.edit', $post->id)}}"><i class="fa fa-edit"></i></a>
                            <form action="{{route('post.delete', $post->id)}}" method="post" enctype="multipart/form">
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
                <h4>No Posts!</h4>
                <div class="pull-right">
                  <span>Write your first blog post</span>
                  <a href="{{route('post.create')}}">
                    <button class="btn btn-primary pull-right">Write Post !</button>
                  </a>
                </div>
              </div>
            @endif
          </div>
          {{-- {{'Showing 1 of '. count($posts)}} --}}
          <div class="d-flex">
            <div class="mx-auto">
              {{$posts->links()}}
            </div>
          </div>
    @endsection

    @section('allposts-scripts')
        <!-- Page level plugins -->
        <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

        <!-- Page level custom scripts -->
        {{-- <script src="{{asset('js/demo/datatables-demo.js')}}"></script> --}}
    @endsection
</x-admin-master>