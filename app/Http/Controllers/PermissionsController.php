<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
    public function rolePermissions(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::all();
        return view('admin.roles_permissions', compact('role', 'permissions'));
    }

    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions', compact('permissions'));
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        if ($id > 0) {
            $model = Permission::findById($id);
        } else {
            $model = new Permission();
        }
        $model->name = $request->input('name');
        $model->save();
        return $model;
    }

    public function updateRolePermissions(Request $request, Role $role)
    {
        $permissions = $request->input('permissions');
        $role->syncPermissions($permissions);
        return back();
    }

    public function show(Permission $permission)
    {
        return $permission;
    }

    public function delete(Permission $permission)
    {
        $permission->delete();
        return response()->json(null, 204);
    }

}
