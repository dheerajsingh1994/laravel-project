<?php

use Illuminate\Support\Facades\Route;

// blog detail
Route::get('/post/{post}', 'PostController@show')->name('post');

Route::middleware('auth')->group(function(){

Route::get('/posts/create', 'PostController@create')->name('post.create');
Route::get('/posts', 'PostController@index')->name('posts.index');
Route::post('/posts', 'PostController@store')->name('post.store');
Route::delete('/posts/{post}/delete', 'PostController@delete')->name('post.delete');

// Route::get('/posts/{post}/edit', 'PostController@edit')->name('post.edit');

Route::put('/posts/{post}/update', 'PostController@update')->name('post.update');

});

// Route::get('/posts', 'PostController@index')->name('posts.index');

// edit post [POLICY use example]
Route::get('/posts/{post}/edit', 'PostController@edit')->middleware('can:view,post')->name('post.edit');