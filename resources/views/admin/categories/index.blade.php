<x-admin-master>
    @section('content')
        <h1>Categories</h1>
        @if(session('category-added'))
            <div class="alert alert-success">{!!session('category-added')!!}</div>
        @elseif(session('category-updated'))
            <div class="alert alert-success">{!!session('category-updated')!!}</div>
        @elseif(session('category-deleted'))
            <div class="alert alert-danger">{!!session('category-deleted')!!}</div>  
        @endif
        <div class="row">
            <div class="col-md-6 mb-3">
                @if($categoryEdit)
                    <form action="{{route('category.update', $categoryEdit->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="Edit Category">Edit Category</label>
                            <input class="form-control" type="text" id="category" name="category" value="{{$categoryEdit->title}}">
                        </div>
                        <div id="category-length"></div>
                        <button type="submit" id="submit-btn" class="btn btn-warning">Update Category</button>
                        <a href="{{route('categories.index')}}">
                            <button type="submit" class="btn btn-dark">Cancel</button>
                        </a>
                    </form>
                @else
                    <form action="{{route('category.create')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="Add Category">Add Category</label>
                            <input class="form-control" type="text" id="category" name="category" value="">
                        </div>
                        <div id="category-length"></div>
                        <button type="submit" id="submit-btn" class="btn btn-primary">Add Category</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Catgories</h6>
            </div>
            @if(($categories))
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
                      <th>Edit Category</th>
                      <th>Update Category</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Slug</th>
                      <th>Created at</th>
                      <th>Updated at</th>
                      <th>Edit Category</th>
                      <th>Update Category</th>
                    </tr>
                  </tfoot>
                  <tbody>
                      @foreach ($categories as $category)
                        <tr>
                          <td>{{$category->id}}</td>
                          <td><a href="{{route('category.edit', $category->id)}}">{{$category->title}}</a></td>
                          <td>{{$category->slug}}</td>
                          <td>{{$category->created_at->diffForhumans()}}</td>
                          <td>{{$category->updated_at->diffForhumans()}}</td>
                          <td>
                            {{-- @can('view',$category) --}}
                            <a href="{{route('category.quickedit', $category->id)}}">
                                {{-- <input type="hidden" name="quick_edit" value={{$category->id}} > --}}
                                <button class="btn btn-primary">Quick Edit</button>
                            </a>
                            {{-- @endcan --}}
                            {{-- hides buttons --}}
                          </td>
                          <td>
                            <form action="{{route('category.destroy', $category->id)}}" method="post" enctype="multipart/form">
                              @csrf
                              @method('DELETE')
                              <input type="hidden" name="category" value="{{$category->title}}">
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
                <h4>No Category!</h4>
                <div class="pull-right">
                  <span>Start adding categories</span>
                    <a href="{{route('category.create')}}">
                        <button class="btn btn-primary pull-right">Add Category !</button>
                    </a>
                </div>
              </div>
            @endif
          </div>

    @endsection
</x-admin-master>