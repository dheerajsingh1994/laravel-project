<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * Get all of the tags for the video.
     */
    public function tags(){
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
