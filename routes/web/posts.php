<?php

use Illuminate\Support\Facades\Route;

Route::get('/post/{post}', 'PostController@show')->name('post');

Route::middleware('auth')->group(function(){
Route::get('admin/posts', 'PostController@index')->name('posts.index');

        Route::get('admin/posts/create', 'PostController@create')->name('post.create');
        Route::post('admin/posts/store', 'PostController@store')->name('post.store');
        // Route::get('/posts/{post}/edit', 'PostController@edit')->name('post.edit');
        Route::put('admin/posts/{post}/update', 'PostController@update')->name('post.update');
        Route::delete('admin/posts/{post}/delete', 'PostController@delete')->name('post.delete');
});


// Route::get('/posts', 'PostController@index')->name('posts.index');

// edit post [POLICY use example]
Route::get('/posts/{post}/edit', 'PostController@edit')->middleware('can:view,post')->name('post.edit');