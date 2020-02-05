<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::orderBy('id', 'desc')->paginate(10);
        return view('admin.positions', ['positions' => $positions]);
    }

    public function store(Request $request)
    {
        if ($request->id && $request->id > 0) {
            $cat = Position::find($request->id);
        } else {
            $cat = new Position();
        }
        $cat->name = $request->name;
        $cat->description = $request->description;
        $cat->save();
        return redirect()->route('positions.all');
    }


    public function show(Position $Position)
    {
        return response()->json($Position, 200);
    }

    public function destroy(Position $Position)
    {
        $Position->delete();
        return response()->json([], 204);
    }
}
