<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    //
    public function index(){
        $roles = Role::all();
        return view('admin.roles.index', [
            'roles' => $roles,
            'roleEdit' => ''
            ]);
    }

    public function create(){
        request()->validate([
            'role' => ['required','min:3']
        ]);

        $data = [
            'name' => Str::ucfirst(request('role')),
            'slug' => Str::of(Str::lower(request('role')))->slug('-')
        ];
        
        Role::create($data);

        session()->flash('added-msg', 'Added new role '.$data['name']);
        return back();
    }

    public function quickedit(Role $role){
        // dd(request()->segment(3));
        // dd($role);

        $roles = Role::all();
        return view('admin.roles.index', [
            'roleEdit' => $role,
            'roles' => $roles
            ]);
    }

    public function edit(Role $role){
        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => Permission::all()
            ]);
    }

    public function delete(Role $role){
        $role->delete();

        session()->flash('deleted-msg', 'Role '.$role->name.' has been deleted');
        return back();        
    }

    public function update(Role $role){
        $role->name = Str::ucfirst(request('role'));
        $role->slug = Str::of(Str::lower(request('role')))->slug('-');

        // if($role->isDirty('name')){
        //     session()->flash('roleupd-msg', 'Please edit Role first');
        //     return back();
        // }

        $role->save();

        session()->flash('updated-msg', 'Role Updated: '.$role->name);
        return redirect()->route('roles.index');
    }

    /* Attach */
    public function attach(Role $role){
        $role->permissions()->attach(request('permission'));

        session()->flash('attached', '<strong>Attached Permission:</strong> <em>'.request('permission_name').'</em>');
        return back();
    }

    /* Detach */
    public function detach(Role $role){
        $role->permissions()->detach(request('permission'));
        
        session()->flash('detached', '<strong>Permission Detached:</strong> <em>'.request('permission_name').'</em>');
        return back();
    }
}
