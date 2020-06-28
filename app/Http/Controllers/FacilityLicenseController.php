<?php

namespace App\Http\Controllers;

use App\ApplicationApproval;
use App\ApplicationApprovalCarbonCopy;
use App\FacilityLicense;
use App\UserApplication;
use Illuminate\Http\Request;

class FacilityLicenseController extends Controller
{
    public function create(UserApplication $application)
    {
        $application->load(['license', 'applicationType', 'facility']);

//        return $application->license;

        return view('admin.manage_facility_license', compact('application'))
            ->with(['license' => $application->license, 'isRequired' => $application->license ? false : true]);
    }


    public function store(Request $request, UserApplication $application)
    {
        $id = $request->input('id');
        if ($id != null && $id > 0) {
            $app = FacilityLicense::find($id);
        } else {
            $app = new FacilityLicense();
        }

        if ($request->input('signed') == 'on') {
            $app->signed_at = now();
        } else {
            $app->signed_at = null;
        }


        $app->user_application_id = $application->id;
        $app->user_id = auth()->id();
        $app->ref_number = $application->application_id;
        $app->reason = $request->input('reason');
        $app->body = $request->input('body');
        $app->save();

        if ($app->signed_at != null) {
            $facility = $app->userApplication->facility;
            $facility->license_issued_at = now();
            $facility->license_expires_at = now()->addYears(2);
            $facility->update();
        }

        return redirect()->route('userApplication')->with('success', 'License successfully saved');
    }

    public function viewLicense(FacilityLicense $license)
    {
        $license->load(['userApplication.facility']);
        return view('facility_license', compact('license'));
    }
}
