<?php

Route::get('/categories', 'CategoryController@index')->name('categories.index');
Route::post('/categories/show', 'CategoryController@show')->name('category.show');

Route::post('/categories/create', 'CategoryController@create')->name('category.create');

Route::get('/categories/{category}/quickedit', 'CategoryController@quickedit')->name('category.quickedit');
Route::get('/categories/{category}/edit', 'CategoryController@edit')->name('category.edit');

Route::put('/categories/{category}/update', 'CategoryController@update')->name('category.update');

Route::delete('/categories/{category}/destroy', 'CategoryController@destroy')->name('category.destroy');
