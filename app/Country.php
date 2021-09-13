<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * Get all of the posts for the country.
     * 
     * @param @table - from which data is required
     * @param @table - intermediate table 
     * 
     * @return array
     * 
     * @reference -https://laravel.com/docs/8.x/eloquent-relationships#has-many-through
     */ 
    public function posts(){
        return $this->hasManyThrough('App\Post', 'App\User');

        // if the coloumn name is different in intermediate table
        return $this->hasManyThrough('App\Post', 'App\User', 'the_country_id');

        // if the coloumn name is different in main table
        return $this->hasManyThrough('App\Post', 'App\User', 'country_id', 'the_user_id');

        // if the coloumn names are different in intermediate and main table
        /**
         * where the_country_id is country coloumn in --table=users and 
         * the_user_id is user coloumn in --table=posts
         * */ 
        return $this->hasManyThrough('App\Post', 'App\User', 'the_country_id', 'the_user_id');
    }
    
}
