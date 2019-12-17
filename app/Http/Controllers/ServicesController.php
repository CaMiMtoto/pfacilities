<?php

namespace App\Http\Controllers;

use App\Facility;
use App\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('id', 'desc')->paginate(10);
        return view('admin.services', ['services' => $services]);
    }

    public function store(Request $request)
    {
        if ($request->id && $request->id > 0) {
            $model = Service::find($request->id);
        } else {
            $model = new Service();
        }
        $model->name = $request->name;
        $model->description = $request->description;
        $model->save();
        return response()->json($model, 200);
    }


    public function show(Service $service)
    {
        return response()->json($service, 200);
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json([], 204);
    }
}
