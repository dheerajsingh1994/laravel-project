<x-admin-master>
    @section('content')
        <h1>Create Post</h1>

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