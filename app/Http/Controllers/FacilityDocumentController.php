<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\FacilityDocument;
use App\Position;
use App\User;
use App\UserApplication;
use Illuminate\Http\Request;

class FacilityDocumentController extends Controller
{
    public function find(UserApplication $userApplication,ApplicationType $applicationType,User $user)
    {
        $docs=FacilityDocument::with(['document','facility'])->where([
            ['application_type_id','=',$applicationType->id],
            ['user_id','=',$user->id],
            ['user_application_id','=',$userApplication->id]
        ])->get();
        $positions=Position::all();
        return view('docs',compact('docs'))->with([
            'userApplication'=>$userApplication,
            'positions'=>$positions
        ]);
    }

    public function viewDoc(FacilityDocument $document)
    {
//      return $document;
        return view('viewDoc',compact('document'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FacilityDocument  $facilityDocument
     * @return \Illuminate\Http\Response
     */
    public function show(FacilityDocument $facilityDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FacilityDocument  $facilityDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(FacilityDocument $facilityDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FacilityDocument  $facilityDocument
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FacilityDocument  $facilityDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacilityDocument $facilityDocument)
    {
        //
    }
}
