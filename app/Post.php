<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
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
}
