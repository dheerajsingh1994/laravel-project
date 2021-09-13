<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $guarded = [];

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    // Illustration
    public function illutrationUsers(){ // get users of a particular role
        return $this->belongsToMany(User::class);
        // *Query 
        // select `user`.*, `role_user`.`role_id` as `pivot_role_id`, `role_user`.`user_id` as `pivot_user_id` from `user` inner join `role_user` on `user`.`id` = `role_user`.`user_id` where `role_user`.`role_id` = {run_time_role-id}
    }
}
