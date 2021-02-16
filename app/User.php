<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'avatar', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // image storage
    public function getAvatarAttribute($value){
        return asset('storage/'.$value);
    }

    // using a mutator, getting password and encrypt
    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    // for reference only
    public function illustrationPost(){
        // return $this->hasOne('App\Post', @first_param, @second_param);
        // @first_param = 'user_reference_id_field', @second_param = 'post_primary_id'
        
        return $this->hasOne('App\Post');
        /** this will automatically look in post table for the corresponsing to the user id [here @user_id]*/

        // if the user id field name is different, we have to pass it as @second_param like below
        return $this->hasOne('App\Post', 'the_user_id'); // where "the_user_id" is the field name of user id
        // if the relationship class has different primary key name
        return $this->hasOne('App\Post', 'the_user_id', 'the_id');

    }

    // user post relationship
    public function user_posts(){
        return $this->hasMany(Post::class);
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    // check for user role
    public function userHasRole($role_name){
        foreach ($this->roles as $role) {
            if(Str::lower($role_name) === Str::lower($role->name)){
                return true;
            }
            return false;
        }

    }
}
