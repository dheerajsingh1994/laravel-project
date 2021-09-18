<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $folder = 'profile-images';

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
        // dd($user);
        // $user->photos()->create(['path'=>'efdfsa.jpg']);
        // dd($user->photos);
        $data = request()->validate([
            'username' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'avatar' => ['file'],
        ]);

        if(request('profile_image')){
            $file = request('profile_image');
            // $name = $file->getClientOriginalName();
            // $file->move(public_path().$this->folder, $name);
            $path1 = $file->store($this->folder);

            // $media = $user->photos()->whereId($user->photo_id)->first();
            // $id = $media->id;

            // // $newMedia = $user->photos()->create(['path' => $path1]);
            // // dd("new", $newMedia);

            // if($id){
            //     $media->path = $path1;
            //     $media->save();
            //     dd("Existing", $media);
            // } else {
            //     $newMedia = $user->photo()->create(['path' => $path1]);
            //     // $newMedia = \App\Media::create(['path' => $path1]);
            //     dd("new", $newMedia);
            // }

            // dd($media);

            // $media = \App\Media::findOrFail($user->photo_id);
            $path = explode('/', $user->avatar);
            @unlink(public_path().'/storage/'.$this->folder.'/'.end($path));
            // $media->save(['path'=>$path1]);

            // $user->photo->path = $path1;

            $data['avatar'] = $path1;
        }
        // dd($data);
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
