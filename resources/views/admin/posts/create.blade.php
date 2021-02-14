<x-admin-master>
    @section('content')
        <h1>Create Post</h1>
        {{-- {{dd($categories)}} --}}
        <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="Title">Title</label>
                <input type="text"
                name="title"
                id="title"
                class="form-control"
                aria-describedby=""
                placeholder="Enter Title">
            </div>
            <div class="fom-group">
                <label for="Category">Category</label>
                <select name="category_id" class="form-control">
                    <option value="0">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="File">Upload Image</label><br>
                <input type="file"
                name="post_image"
                id="post_image"
                class="file">
            </div>
            <div class="form-group">
                <label for="body">Description</label>
                <textarea
                name="body"
                id="body"
                class="form-control"
                cols="30" rows="10"></textarea>
            </div>
            <button
            type="submit"
            class="btn btn-primary"
            id="submit"
            >Submit</button>
        </form>
    @endsection
</x-admin-master>