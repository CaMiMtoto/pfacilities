<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeePosition;
use App\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::with(['facility','position'])
            ->paginate(10);
        $facilities = Facility::all();
        $positions = EmployeePosition::all();
        return view('admin.employees', compact('employees'))
            ->with([
                'facilities' => $facilities,
                'positions' => $positions
            ]);
    }


    public function store(Request $request)
    {
        if ($request->id && $request->id > 0) {
            $cat = Employee::find($request->id);
        } else {
            $cat = new Employee();
        }
        $cat->name = $request->name;
        $cat->phone = $request->phone;
        $cat->nid = $request->nid;
        $cat->license_number = $request->license_number;
        $cat->facility_id = $request->facility_id;
        $cat->qualification = $request->qualification;
        $cat->position_id = $request->position_id;
        $cat->hired_date = $request->hired_date;
        $cat->contract_end = $request->contract_end;
        $cat->save();
        return redirect()->route('employees.all');
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return Employee
     */
    public function show(Employee $employee)
    {
        return $employee;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return Response
     * @throws \Exception
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response(null, 204);
    }
}
