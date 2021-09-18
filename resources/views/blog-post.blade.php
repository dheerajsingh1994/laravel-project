<x-home-master>
    @section('content')
      <!-- Title -->
      <h1 class="mt-4">{{$post->title}}</h1>

      <!-- Author -->
      <p class="lead">
        by
        <a href="#">{{$post->user->name}}</a>
      </p>

        <hr>

        <!-- Date/Time -->
        <p>Posted on {{$post->created_at}}</p>

        <hr>

        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset($post->post_image)}}" alt="{{$post->title}}" style="height: 250px">

        <hr>

        <!-- Post Content -->
        <p class="lead">{{Str::limit($post->body, '20', '')}}</p>

        <p>{{($post->body)}}</p>

        <blockquote class="blockquote">
          <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
          <footer class="blockquote-footer">Someone famous in
            <cite title="Source Title">Source Title</cite>
          </footer>
        </blockquote>

        <hr>

        <!-- Comments Form -->
        <div class="card my-4">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            <form action="{{route('comments.store')}}" method="POST">
              @csrf
              @method('POST')
              <div class="row">
                @if (session('msg'))
                <div class="alert alert-success">{{session('msg')}}</div>                    
                @endif
              </div>
              <input type="hidden" name="post_id" value="{{$post->id}}">
              <div class="form-group">
                <textarea class="form-control @error('body') is-invalid @enderror" name="body" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>

        <!-- Comment with nested comments -->
        @if(count($comments) > 0)
        @foreach ($comments as $comment)

        <div class="media mb-4">
          @if ($comment->photo)
            <img class="d-flex mr-3 rounded-circle" src="{{$comment->photo}}" alt="" height="60" width="60">
          @else
            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
          @endif
          <div class="media-body">
            <h4 class="mt-0 media-heading">
              {{$comment->author}}
              <small>{{$comment->created_at->diffForHumans()}}</small>
            </h4>
            <div class="comment-body">
              {{$comment->body}}

            </div>
            {{-- <button class="btn btn-info comment-reply" type="button">Reply</button> --}}
            <div class="media mt-4">
              @if (Auth::user()->avatar)
                <img class="d-flex mr-3 rounded-circle" src="{{Auth::user()->gravatar}}" alt="" height="60" width="60">
              @else
                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
              @endif
              <div class="media-body">
                <h5 class="mt-0">{{Auth::user()->name}}</h5>
                <form action="{{route('replies.store')}}" method="POST">
                  @csrf
                  @method('POST')
                  <input type="hidden" name="comment_id" value="{{$comment->id}}">
                  <div class="form-group">
                    <textarea name="body" class="form-control @error('body') is-invalid @enderror" cols="30" rows="1" placeholder="Type your reply..."></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Reply</button>
      
                </form>
              </div>
            </div>
            
            @if(count($comment->replies) > 0)
            @foreach($comment->replies as $reply)
            @if ($reply->is_active)

            {{-- reply body --}}
            <div class="media mt-4">
              @if ($reply->photo)
                <img class="d-flex mr-3 rounded-circle" src="{{$reply->photo}}" alt="" height="60" width="60">
              @else
                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
              @endif
              <div class="media-body">
                <h5 class="mt-0">{{$reply->author}}</h5>
                <div class="commet-body">
                  {{$reply->body}}
                </div>
                <div class="reply-icons">
                  <i class="fa fa-reply"></i>
                </div>
              </div>
            </div>

            {{-- reply form --}}
            {{-- <div class="media mt-4">
              @if (Auth::user()->avatar)
                <img class="d-flex mr-3 rounded-circle" src="{{Auth::user()->avatar}}" alt="" height="60" width="60">
              @else
                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
              @endif
              <div class="media-body">
                <h5 class="mt-0">{{Auth::user()->name}}</h5>
                <form action="{{route('replies.store')}}" method="POST">
                  @csrf
                  @method('POST')
                  <input type="hidden" name="comment_id" value="{{$comment->id}}">
                  <div class="form-group">
                    <textarea name="body" class="form-control @error('body') is-invalid @enderror" cols="30" rows="1" placeholder="Type your reply..."></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Reply</button>
    
                </form>
              </div>
            </div> --}}

            @endif
            
            @endforeach
            @endif

          </div>
        </div>
            
        @endforeach
        @endif



        <h2>Discus Comment System</h2>
        <div id="disqus_thread"></div>
        <script>
            /**
            *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
            *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
            /*
            var disqus_config = function () {
            this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };
            */
            (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://http-laravel-project-test.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
  
        <script id="dsq-count-scr" src="//http-laravel-project-test.disqus.com/count.js" async></script>
    @endsection
</x-home-master>