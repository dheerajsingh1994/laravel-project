<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comments = \App\Comment::paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $inputs = $request->all();
        $user = \Auth::user();
        // dd($user->avatar);

        // dd($user);

        $inputs['author'] = $user->name;
        $inputs['email'] = $user->email;
        $inputs['photo'] = $user->avatar;

        // dd($inputs);

        $comment = \App\Comment::create($inputs);

        session()->flash('msg', 'Your response has been recorded and sent for approval.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = \App\Post::findOrfail($id);

        $comments = $post->comments;

        return view('admin.comments.show', compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $comment = \App\Comment::findOrfail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $comment = \App\Comment::findOrfail($id);
        $comment->update($request->all());

        session()->flash('msg', 'Comment Updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        \App\Comment::findorfail($id)->delete();
        session()->flash('msg','Comment deleted successfully');
        return redirect()->back();
    }
}
