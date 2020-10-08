<?php

namespace App\Http\Controllers;

use App\DistrictReport;
use App\Facility;
use App\Http\Requests\ValidateDistrictReport;
use App\User;
use Illuminate\Support\Facades\Gate;

class DistrictReportController extends Controller
{
    public function index(User $user)
    {
        if (Gate::denies('view-district-reports'))
            return abort(403, "Unauthorized access");
        $reports = DistrictReport::with(['facility', 'doneBy'])->where('done_by', $user->id)->get();

        $facilities = Facility::where('user_id', '=', $user->id ?? auth()->id())->get();
        return view('admin.reports.district_report', compact('reports', 'facilities'));
    }

    public function store(ValidateDistrictReport $request)
    {
        $request->validated();

        $id = $request->input('id');
        if ($id > 0) {
            $report = DistrictReport::findOrFail($id);
        } else {
            $report = new DistrictReport();
        }

        $report->facility_id = $request->input('facility_id');
        $report->title = $request->input('title');
        if ($request->hasFile('document')) {
            $dir = 'public/files/district/reports/';
            $file = $request->file('document');
            $path = $file->store($dir);
            $report->document = str_replace("$dir", '', $path);
        }
        $report->done_by = auth()->id();
        $report->save();

        return redirect()->to(route('districts.reports.index',auth()->id()));
    }
}
