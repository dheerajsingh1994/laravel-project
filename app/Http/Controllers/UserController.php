<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // users
    public function index(){
        $users = User::all();
        return view('admin.users.index', [
            'users' => $users,
            ]);
    }

    // display profile
    public function show(User $user) {
        $roles = Role::all();
        return view('admin.users.profile', [
            'user' => $user,
            'roles' => $roles
            ]);
    }

    // update profile
    public function update(User $user){
        $data = request()->validate([
            'username' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'avatar' => ['file'],
        ]);

        if(request('profile_image')){
            $data['avatar'] = request('profile_image')->store('profile-images');
        }

        $user->update($data);

        return back();
    }

    public function delete(User $user){
        // dd($user);
        $user->delete();
        session()->flash('userdel-msg', 'User has been Deleted');
        return back();
    }

    // public function attach(Role $role) {
    //     request()->user()->roles()->attach($role);

    //     Session::flash('userattach-msg', 'User Role has been updated');
    //     return back();
    // }

    // public function detach(Role $role) {
    //     request()->user()->roles()->detach($role);

    //     Session::flash('userdetach-msg', 'User Role has been updated');
    //     return back();
    // }

    public function attach(User $user) {
        $user->roles()->attach(request('role'));

        Session::flash('userattach-msg', 'User Role has been updated');
        return back();
    }

    public function detach(User $user) {
        $user->roles()->detach(request('role'));

        Session::flash('userdetach-msg', 'User Role has been updated');
        return back();
    }

}
