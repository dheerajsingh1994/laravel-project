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
        $message->to('dheerajs0894@gmail.com', 'Dheeraj')->subject("Hello");
    });
});


// for reference only
use App\User;
use App\Post;
use App\Role;

/* One to One Relationship */
Route::get('user/{id}/post', function($id){
    $user = User::find($id)->illustrationPost;
    return $user;
});

/* the inverse relationship */
Route::get('post/{id}/user', function($id){
    return Post::find($id)->illustrationUser;
});

/* One to Many relationship */
Route::get('/posts', function(){
    $user = User::find(22);

    foreach($user->illustrationOnetoManyPost as $posts){
        // $title = $posts->title;
        echo $posts->title;echo "<br>";
    }
    // return $title;
});

/* Many to Many relationship */
Route::get('/user/{id}/role', function($id){
    $user = User::find($id);
    foreach($user->illustrationRoles as $roles){
        echo $roles->name;echo "<br>";
    }
});

/* the inverse */
Route::get('/role/{id}/user', function($id){
    $role = Role::find($id);

    foreach ($role->illutrationUsers as $user) {
        echo $user->name; echo "<br>";
    }
    // return $role;
});

/* Access the intermediate table [Pivot Table] */
Route::get('user/pivot', function(){
    $user = User::find(22);

    foreach($user->roles as $role){
        echo $role->pivot->created_at; // we cn also format date using format('y, m, d');
    }
});

/** get post of a country where 
 * post is associated with user AND user is associated with country 
 */
Route::get('country/{id}/posts', function($id){
    $country = \App\Country::findOrFail($id);
    
    foreach ($country->posts as $post) {
        echo $post->title;echo "<br>";
    }
});

/**
 * Polymorphic relations
 */
Route::get('user/{id}/photo', function($id){
    $user = User::findOrFail($id);

    foreach ($user->photos as $photo) {
        echo $photo->path;
    }
});
Route::get('post/{id}/photo', function($id){
    $post = Post::findOrFail($id);

    foreach ($post->photos as $photo) {
        echo $photo->path;
    }
});
// inverse poly
Route::get('photo/{id}/post', function($id){
    $photo = \App\Media::findOrFail($id);
    return $photo->subject;
});
Route::get('photo/{id}/user', function($id){
    $photo = \App\Media::findOrFail($id);
    return $photo->subject;
});

// many to many (poly)
Route::get('post/{id}/tags', function($id){
    $post = Post::findOrFail($id);

    foreach ($post->tags as $tag) {
        echo $tag;
    }
});
Route::get('video/{id}/tags', function($id){
    $video = \App\Video::findOrFail($id);

    foreach ($video->tags as $video) {
        echo $video;
    }
});
Route::get('tag/{id}/posts', function($id){
    $tags = \App\Tag::findOrFail($id);

    foreach ($tags->posts as $post) {
        echo $post;
    }
});




/**
 * Comments and replies section
 */

Route::middleware('auth')->group(function(){

    Route::resource('admin/comments', 'PostCommentController')->middleware('role:admin');
    
    Route::resource('admin/comments/replies', 'CommentReplyController');

});
