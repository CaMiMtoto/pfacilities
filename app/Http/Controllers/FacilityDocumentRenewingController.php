<?php

namespace App\Http\Controllers;

use App\Facility;
use App\FacilityDocumentRenewing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacilityDocumentRenewingController extends Controller
{

    public function renew(Request $request, Facility $facility)
    {
        $renewDoc = new FacilityDocumentRenewing();
        $renewDoc->app_letter = $this->uploadDoc($request->file('app_letter'));
        $renewDoc->district_report = $this->uploadDoc($request->file('district_report'));
        $renewDoc->facility_id = $facility->id;
        $renewDoc->user_id = Auth::id();
        $renewDoc->save();
        return response($renewDoc, 200);
    }

    private function uploadDoc($file)
    {
        $dir = 'public/files/facilitydocs/';
        $path = $file->store($dir);
        return str_replace("$dir", '', $path);
    }


    public function showRenew(Facility $facility)
    {
        $facility->load('facilityDocumentsRenews');
        return view('admin.renewFacility', compact('facility'));
    }

    public function updateRenew(Request $request, FacilityDocumentRenewing $renewing)
    {
        $renewing->status = $request->status;
        $renewing->comment = $request->comment;
        if ($renewing->status == 'renewed') {
            $renewing->issued_at = $request->issued_at;
            $renewing->expires_at = $request->expires_at;

            $renewing->facility->license_issued_at=$request->issued_at;
            $renewing->facility->license_expires_at=$request->expires_at;
        }else{
            $renewing->issued_at = null;
            $renewing->expires_at = null;

            $renewing->facility->license_issued_at=null;
            $renewing->facility->license_expires_at=null;
        }
        $renewing->update();
        $renewing->facility->update();
        return response($renewing, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\FacilityDocumentRenewing $facilityDocumentRenewing
     * @return \Illuminate\Http\Response
     */
    public function show(FacilityDocumentRenewing $facilityDocumentRenewing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\FacilityDocumentRenewing $facilityDocumentRenewing
     * @return \Illuminate\Http\Response
     */
    public function edit(FacilityDocumentRenewing $facilityDocumentRenewing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\FacilityDocumentRenewing $facilityDocumentRenewing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacilityDocumentRenewing $facilityDocumentRenewing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\FacilityDocumentRenewing $facilityDocumentRenewing
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacilityDocumentRenewing $facilityDocumentRenewing)
    {
        //
    }
}
