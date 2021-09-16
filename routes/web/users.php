<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['can:update,user'])->group(function(){
    // user profile
    Route::put('/users/{user}/update', 'UserController@update')->name('user.profile.update');
});

Route::middleware('role:admin')->group(function(){
    // User Route
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::delete('/users/{user}/delete', 'UserController@delete')->name('user.delete');
    Route::put('/users/{user}/attach', 'UserController@attach')->name('user.role.attach');
    Route::put('/users/{user}/detach', 'UserController@detach')->name('user.role.detach');
});

Route::middleware(['can:view,user'])->group(function(){
    Route::get('/users/{user}/profile', 'UserController@show')->name('user.profile.show');
});
