<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'title', 'slug',
    ];

    // category post relationship
    public function cat_posts(){
        return $this->hasMany(Post::class);
    }
}
