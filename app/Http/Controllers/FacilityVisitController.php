<?php

namespace App\Http\Controllers;

use App\Facility;
use App\FacilityVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacilityVisitController extends Controller
{

    public function visit(Request $request,Facility $facility)
    {
        $fac=new FacilityVisit();
        $fac->date=$request->date;
        $fac->comment=$request->comment;
        $fac->visitor=$request->visitor;
        $fac->purpose=$request->purpose;
        $fac->recommendations=$request->recommendations;
        $fac->facility_id=$facility->id;
        if ($request->document){
            $file=$request->file('document');
            $dir = 'public/files/facility/visit/docs/';
            $path = $file->store($dir);
            $fac->document= str_replace("$dir", '', $path);
        }
        $fac->user_id=Auth::id();
        $fac->save();
        return redirect()->back()->with(['message'=>'Saved']);
    }
    public function viewVisits(Facility $facility)
    {
        $facility->load('facilityVisits');
        return view('visit_facility',compact('facility'));
    }

    public function uploadDoc(Request $request,FacilityVisit $facility)
    {
        if ($request->document){
            $file=$request->file('document');
            $dir = 'public/files/facility/visit/docs/';
            $path = $file->store($dir);
            $facility->document= str_replace("$dir", '', $path);
        }
        $facility->user_id=Auth::id();
        $facility->save();
        return response($facility,200);
    }

    public function summary(FacilityVisit $facilityVisit)
    {
        $facilityVisit->load([
            'facility',
            'user'
        ]);
        return view('visit_summary',compact('facilityVisit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FacilityVisit  $facilityVisit
     * @return \Illuminate\Http\Response
     */
    public function edit(FacilityVisit $facilityVisit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FacilityVisit  $facilityVisit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacilityVisit $facilityVisit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FacilityVisit  $facilityVisit
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacilityVisit $facilityVisit)
    {
        //
    }
}
