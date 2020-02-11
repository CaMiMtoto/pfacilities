<?php

namespace App\Http\Controllers;

use App\Category;
use App\District;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function summary()
    {
        $districts = District::all();
        $categories = Category::all();
        $services = Service::all();
        return view('admin.reports.summary', compact('districts'))
            ->with(['categories' => $categories, 'services' => $services]);
    }

    public function facilities(Request $request)
    {
        $category = Category::find($request->category);
        $service = Service::find($request->service);
        $district = District::find($request->district);

        $facilities = DB::table('facilities')
            ->join('sectors', 'sectors.id', '=', 'facilities.sector_id')
            ->join('districts', 'districts.id', '=', 'sectors.district_id')
            ->where([
                ['facilities.category_id', '=', $request->category],
                ['sectors.district_id', '=', $request->district],
                ['facilities.service_id', '=', $request->service]
            ])->select('facilities.*')->get();
        return view('admin.reports.facilities_from_district', compact('facilities'))
            ->with([
                'service' => $service,
                'category' => $category,
                'district' => $district
            ]);
    }
}
