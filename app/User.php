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
        'username', 'name', 'avatar', 'email', 'password', 'photo_id'
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

    // user post relationship
    public function user_posts(){
        return $this->hasMany(Post::class);
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class)->withPivot('created_at');
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

    // one to many relationship
    public function illustrationOnetoManyPost(){
        return $this->hasMany(Post::class);
    }

    // many to many relationship
    /** NOTE Pivot table is an example of intermediate table with relationships between two other “main” tables. */
    public function illustrationRoles(){ // get roles of a user
        return $this->belongsToMany('App\Role');
        /** @Incase the pivit table is not named as per the convention */
        // return $this->belongsToMany('App\Role', @custome_tbl_name, @foreigb_key1, @foreign_key2);
        // return $this->belongsToMany('App\Role', 'all_user_roles', 'user_id', 'role_id');
    }

    // 11-09-2021
    /**
     * Get the user's image.
     * morphMany() if more than one image
     * morphOne() if only one image
     */
    public function photos(){
        return $this->morphMany('App\Media', 'subject');
    }

    /**
     * Fetch logged used gravatar
     */
    public function getGravatarAttribute(){
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/".$hash.'?d=mm&size=64x64';
    } 

}
