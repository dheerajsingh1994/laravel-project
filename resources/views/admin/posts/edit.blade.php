<x-admin-master>
    @section('content')
        <h1>Create Post</h1>

        <form action="{{route('post.update', $post->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="Title">Title</label>
                <input type="text"
                name="title"
                id="title"
                class="form-control"
                aria-describedby=""
                value="{{$post->title}}"
                placeholder="Enter Title">
            </div>
            <div class="fom-group">
                <label for="Category">Category</label>
                <select name="category_id" class="form-control">
                    <option value="0">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                        {{-- <option value="{{$category->id}}">{{$category->title}}</option> --}}
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="File">Upload Image</label><br>
                <input type="file"
                name="post_image"
                id="post_image"
                class="file">
                <br><br>
                @if($post->post_image)
                    <div><img height="50px" src="{{$post->post_image}}" alt="{{$post->title}}"></div>
                @endif
            </div>
            <div class="form-group">
                <label for="body">Description</label>
                <textarea
                name="body"
                id="body"
                class="form-control"
                cols="30" rows="10">{{$post->body}}</textarea>
            </div>
            <button
            type="submit"
            class="btn btn-primary"
            id="submit"
            >Submit</button>
        </form>
    @endsection
</x-admin-master>