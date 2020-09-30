<?php

// Routes are secured globally from RouteServiceProvider
Route::get('/roles', 'RoleController@index')->name('roles.index');

Route::post('/roles/create', 'RoleController@create')->name('role.create');

Route::get('/roles/{role}/quickedit', 'RoleController@quickedit')->name('role.quickedit');
Route::get('/roles/{role}/edit', 'RoleController@edit')->name('role.edit');

Route::put('/roles/{role}/update', 'RoleController@update')->name('role.update');
Route::delete('/roles/{role}/delete', 'RoleController@delete')->name('role.delete');

/* Role Permissions Route */
Route::put('/roles/{role}/attach', 'RoleController@attach')->name('role.permission.attach');
Route::put('/roles/{role}/detach', 'RoleController@detach')->name('role.permission.detach');