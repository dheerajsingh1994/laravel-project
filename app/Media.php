<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'path',
        'thumb_path',
        'subject_id',
        'subject_path',
    ];
    /**
     * Get the parent subject model (user or post).
     * 
     * @reference - https://laravel.com/docs/8.x/eloquent-relationships#one-to-many-polymorphic-relations
     */
    public function subject(){
        return $this->morphTo();
    }
}
