<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Category;
use Illuminate\Support\Facades\Session; // session
use DB;

class PostController extends Controller
{
    // show all posts
    public function index(){
        // $posts = auth()->user()->user_posts; // authorization done from policy
        // $posts = Post::all()->paginate(1);
        // $posts = DB::table('posts')->paginate(1);

        // if(auth()->user()->userHasRole('admin')){
        //     echo "admin";
        // } else {
        //     echo "not admin";
        // }
        // die;
        $posts = auth()->user()->userHasRole('admin')? Post::paginate(10) : auth()->user()->user_posts()->paginate(10);
        
        /*
            $users = User::where('id', $posts->user_id)->get();
            dd($users);
        */

        return view('admin.posts.index')->with('posts', $posts);
    }

    // show singular post
    public function show (Post $post){
        // if(auth()->user()->can('view',$post)){
            return view('blog-post', ['post' => $post]);
        // }
    }

    // show add form
    public function create (){
        $this->authorize('create', Post::class);
        $categories = Category::all();
        return view('admin.posts.create')->withCategories($categories);;
    }

    // store post
    public function store(Request $request){
        $this->authorize('create', Post::class);

        $data = request()->validate([
            'title'         =>  'required',
            'category_id'   =>  'required',
            'body'          =>  'required',
            'post_image'    =>  'file'
        ]);

        if(request('post_image')){
            $data['post_image'] = request('post_image')->store('post-images');
        }

        // dd($data);
        // merge post author with post 
        auth()->user()->user_posts()->create($data);

        // display success flash message [METHOD-1]
        Session::flash('postadd-msg', 'Post has been added successfully');

        return redirect()->route('posts.index');
    }

    // delete post
    public function delete(Request $request, $id){
        $post = Post::find($id);
        $this->authorize('delete', $post);

        // dd($post->post_image);
        unlink(public_path()."/".$post->post_image);

        $post->delete();

        // display flash message [METHOD-2]
        $request->session()->flash('postdel-msg', 'Post Deleted Successfully');
        /* 
            or
            session()->flash('message', 'Post Deleted Successfully');
        */

        // return redirect()->back(); OR
        return back();
    }

    // edit post [METHOD-1]
    /* public function edit($id){
        $post = Post::find($id);
        return view('admin.posts.edit')->with('post', $post);
    } */

    // edit post [METHOD-2]
    public function edit(Post $post){
        // UNAUTHORIZED user restriction
        // $this->authorize('view', $post);
        $categories = Category::all();
        return view('admin.posts.edit', compact('post'))->withCategories($categories);
    }

    // update post [METHOD-1][understandable]
    public function update(Request $request, $id){
        // dd($request, request('post_image'));
        $request->validate([
            'title'         =>  'required',
            'category_id'   =>  'required',
            'body'          =>  'required', 
            'post_image'    =>  'file'
        ]);

        $update_post = Post::find($id);
        $update_post->title = $request->get('title');
        $update_post->category_id = $request->get('category_id');
        $update_post->body  = $request->get('body');

        if(request('post_image')){
            $update_post['post_image'] = request('post_image')->store('post-images');
        }

        $this->authorize('update',$update_post);

        // merge post author with post [REPLACES author with the name of logged one]
        // auth()->user()->user_posts()->save($update_post);
        // OR
        $update_post->update();

        // display success flash message [METHOD-1]
        Session::flash('postadd-msg', 'Post has been updated!');

        return redirect()->route('posts.index');
    }

    // update post [METHOD-2]
    /* public function update(Post $post){
        $input = request()->validate([
            'title' => 'required|min:10',
            'body'  => 'required',
            'post_image' => 'required'
        ]);

        $post = new Post();
        $post->title = $input['title'];
        $post->body = $input['body'];
            
        // check for image
        if(request('post_image')){
            $input['post_image'] = request('post_image')->store('post-images');
            $post->post_image = $input['post_image'];
        }
        
        $post->save();
        return redirect()->route('posts.index');
    } */ //  not complete not working
}
