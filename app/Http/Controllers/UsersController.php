<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateUser;
use App\Position;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $positions = Position::all();
        $search = \request('q');
        $users = User::with('position')
            ->where('name', 'LIKE', "%$search%")
            ->orWhere('role', 'LIKE', "%$search%")
            ->orWhere('email', 'LIKE', "%$search%")
            ->paginate(10);
        return view('admin.users', compact('users'))
            ->with(['positions' => $positions]);
    }


    public function store(ValidateUser $request)
    {
        $request->validated();

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
        if ($request->ajax())
            return response($user, 200);
        return back()->with('success', 'User successfully saved');
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
