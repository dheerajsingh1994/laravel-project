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
            </div>
        </div>

    @endsection
</x-admin-master>