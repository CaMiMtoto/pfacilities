<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->withCount('permissions')->latest()->get();
//        return  $roles;
        return view('admin.roles', compact('roles'));
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        if ($id > 0) {
            $role = Role::findById($id);
        } else {
            $role = new Role();
        }
        $role->name = $request->input('name');
        $role->save();
        return $role;
    }

    public function delete(Role $role)
    {
        $role->delete();
        return response()->json(null, 204);
    }

    public function show(Role $role)
    {
        return $role;
    }
}
