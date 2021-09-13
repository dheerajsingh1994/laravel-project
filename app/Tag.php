<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Get all of the users for the tag.
     */
    public function users(){
        return $this->morphedByMany('App\User', 'taggable');
    }

    /**
     * Get all of the posts for the tag.
     */
    public function posts(){
        return $this->morphedByMany('App\Post', 'taggable');
    }
}
