<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    //
    public function index(){
        $permissions = Permission::all();
        return view('admin.permissions.index', [
            'permissions' => $permissions,
            'permissionEdit' => ''
            ]);
    }

    public function create(){
        request()->validate([
            'permission' => ['required']
        ]);

        $data = [
            'name' => Str::ucfirst(request('permission')),
            'slug' => Str::of(Str::lower(request('permission')))->slug('-')
        ];

        Permission::create($data);
        session()->flash('permission-added', '<strong>Permission added:</strong> <em>'.request('permission').'</em>');
        return back();
    }

    public function quickedit(Permission $permission){
        $permissions = Permission::all();
        return view('admin.permissions.index', [
            'permissionEdit' => $permission,
            'permissions' => $permissions
        ]);
    }

    public function edit(Permission $permission){
        return view('admin.permissions.edit')->with('permission', $permission);
    }

    public function update(Permission $permission){
        request()->validate([
            'permission' => ['required','min:3']
        ]);

        if($permission->isDirty('name')){
            session()->flash('permission-update', 'Please edit Permission first');
            return back();
        }

        $permission->name = Str::ucfirst(request('permission'));
        $permission->slug = Str::of(Str::lower(request('permission')))->slug('-');

        $permission->save();
        
        session()->flash('permission-update', '<strong>Permission Updated:</strong> <em>'.request('permission').'</em>');
        return redirect()->route('permissions.index');
    }

    public function delete(Permission $permission){
        $permission->delete();

        session()->flash('permission-delete', '<strong>Permission deleted:</strong> <em>'.request('permission').'</em>');
        return back();
    }
}
