<?php

/* Routes ares protected globally from RouteServiceProvider */
Route::get('/permissions', 'PermissionController@index')->name('permissions.index');
Route::post('/permissions/create', 'PermissionController@create')->name('permission.create');

Route::get('/permissions/{permission}/quickedit', 'PermissionController@quickedit')->name('permission.quickedit');
Route::get('/permissions/{permission}/edit', 'PermissionController@edit')->name('permission.edit');

Route::put('/permissions/{permission}/update', 'PermissionController@update')->name('permission.update');
Route::delete('permissions/{permission}/delete', 'PermissionController@delete')->name('permission.delete');