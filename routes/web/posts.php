<?php

use Illuminate\Support\Facades\Route;

Route::get('/posts', 'PostController@index')->name('posts.index');
Route::get('/posts/create', 'PostController@create')->name('post.create');
Route::post('/posts/store', 'PostController@store')->name('post.store');
Route::get('/post/{post}', 'PostController@show')->name('post');
// Route::get('/posts/{post}/edit', 'PostController@edit')->name('post.edit');
Route::put('/posts/{post}/update', 'PostController@update')->name('post.update');
Route::delete('/posts/{post}/delete', 'PostController@delete')->name('post.delete');


// Route::get('/posts', 'PostController@index')->name('posts.index');

// edit post [POLICY use example]
Route::get('/posts/{post}/edit', 'PostController@edit')->middleware('can:view,post')->name('post.edit');