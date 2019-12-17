<?php

namespace App\Http\Controllers;

use App\Facility;
use Illuminate\Support\Facades\DB;

class FacilityReportController extends Controller
{
    public function expiring()
    {
        $facilities = Facility::with(['category', 'service'])
            ->select('*',DB::raw('DATEDIFF(license_expires_at,license_issued_at)  DaysRem'))
            ->having('DaysRem', '<', 30)
            ->get();
        return view('admin.expiring_facilities',compact('facilities'));
    }
}
