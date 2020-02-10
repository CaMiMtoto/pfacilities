<?php

namespace App\Http\Controllers;

use App\EmployeePosition;
use Illuminate\Http\Request;

class EmployeePositionController extends Controller
{

    public function index()
    {
        $EmployeePositions = EmployeePosition::orderBy('id', 'desc')->paginate(10);
        return view('admin.employeePositions', ['positions' => $EmployeePositions]);
    }

    public function store(Request $request)
    {
        if ($request->id && $request->id > 0) {
            $cat = EmployeePosition::find($request->id);
        } else {
            $cat = new EmployeePosition();
        }
        $cat->name = $request->name;
        $cat->description = $request->description;
        $cat->save();
        return redirect()->route('employeePositions.all');
    }


    public function show(EmployeePosition $position)
    {
        return response()->json($position, 200);
    }

    public function destroy(EmployeePosition $position)
    {
        $position->delete();
        return response()->json([], 204);
    }
}
