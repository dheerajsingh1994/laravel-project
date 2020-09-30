<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Category::all();
        return view('admin.categories.index', [
            'categories'    => $data,
            'categoryEdit'  => ''
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        request()->validate([
            'category' => ['required']
        ]);

        $data = [
            'title' => Str::ucfirst(request('category')),
            'slug'  => Str::of(Str::lower(request('category')))->slug('-')
        ];

        Category::create($data);
        session()->flash('category-added', '<strong>Category added:</strong> <em>'.request('category').'</em>');
        return back();
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
    }

    public function quickedit(Category $category) {
        $categories = Category::all();

        return view('admin.categories.index', [
            'categoryEdit'  => $category,
            'categories'    => $categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['categoryEdit'  => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category)
    {
        //
        request()->validate([
            'category'  => ['required']
        ]);
        
        $category->title = Str::ucfirst(request('category'));
        $category->slug = Str::of(Str::lower(request('category')))->slug('-');

        if(!$category->isDirty('title')){
            session()->flash('category-updated', 'Please edit Permission first');
            return back();
        }

        $category->save();

        session()->flash('category-updated', '<strong>Category updated:</strong> <em>'.request('category').'</em>');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('category-deleted', '<strong>Category deleted:</strong> <em>'.request('category').'</em>');
        return back();
    }
}
