<?php

namespace App\Http\Controllers;

use App\Position;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $positions = Position::all();
        $users = User::with('position')->paginate(10);
        return view('admin.users', compact('users'))
            ->with(['positions' => $positions]);
    }


    public function store(Request $request)
    {
        $id = $request->id;
        if ($id > 0) {
            $user = User::findOrFail($id);
        } else {
            $user = new User();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        $position = $request->position;
        if ($request->role == 'normal') {
            $user->position_id = null;
        } else {
            $user->position_id = $position;
        }
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response($user, 200);
    }


    public function show(User $user)
    {
        return response($user, 200);
    }


    public function destroy(User $user)
    {
        $user->delete();
        return response(null, 404);
    }
}
