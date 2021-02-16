<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

// Home Controller
Route::get('/', 'HomeController@index')->name('home');

// admin login
Route::middleware('auth')->group(function(){
    Route::get('/admin', 'AdminController@index')->name('admin.index');
});


Route::get('/email', function(){
    $data = [
        'title' => 'Hi Students',
        'content' => 'This is test email'
    ];

    Mail::send('emails.test', $data, function($message){
        $message->to('dks0894@gmail.com', 'Dheeraj')->subject("Hello");
    });
});


// for reference only
use App\User;
use App\Post;

/* One to One Relationship */
Route::get('user/{id}/post', function($id){
    $user = User::find($id)->illustrationPost;
    return $user;
});

/* the inverse relationship */
Route::get('post/{id}/user', function($id){
    return Post::find($id)->illustrationUser;
});