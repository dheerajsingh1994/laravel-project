<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-cog"></i>
      <span>Blog Posts</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Posts</h6>
        <a class="collapse-item" href="{{route('post.create')}}">Create Post</a>
        <a class="collapse-item" href="{{route('posts.index')}}">Manage Posts</a>
      </div>
    </div>
</li>
@if(auth()->user()->userHasRole('Admin'))
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#comments" aria-expanded="true" aria-controls="comments">
    <i class="fas fa-fw fa-cog"></i>
    <span>Post Comments</span>
  </a>
  <div id="comments" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Comments</h6>
      <a class="collapse-item" href="{{route('comments.index')}}">All Comments</a>
      {{-- <a class="collapse-item" href="{{route('posts.index')}}">Manage Posts</a> --}}
    </div>
  </div>
</li>
@endif