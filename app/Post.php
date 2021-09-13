<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    protected $guarded = [];


    // illustration [belongs to relationship]
    public function illustrationUser(){
        return $this->belongsTo('App\User', 'user_id');
    }
    /** Note: if you're breaking naming conventions your code will not be that simple - it will be then not enough to specify related class name only, you will have to pass additional parameter/s (depending of type of relationship it could be table name, column name or names) to override values Laravel normally assumes (what works perfectly when naming conventions are followed) */

    /** According to laravel convention we should use the name of the model but in case we don't want do we have to provide the foreign key as param to make it work */


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    // mutataor example (problems while shifting database)
    /*
    public function setPostImageAttribute($value){
        $this->attributes['post_image'] = asset($value);
    }
    */

    // accessor example (can be used with large data)
    public function getPostImageAttribute($value){
        return asset('storage/'.$value);
    }

    // 11-09-2021
    /**
     * Get the post's image.
     * morphMany() if more than one image
     * morphOne() if only one image
     */
    public function photos(){
        return $this->morphMany('App\Media', 'subject');
    }

    /**
     * Get all of the tags for the post.
     */
    public function tags(){
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
