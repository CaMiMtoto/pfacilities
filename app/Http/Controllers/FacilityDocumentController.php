<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\FacilityDocument;
use App\Position;
use App\User;
use App\UserApplication;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FacilityDocumentController extends Controller
{
    public function find(UserApplication $userApplication, ApplicationType $applicationType, User $user)
    {
        $docs = FacilityDocument::with(['document', 'facility'])->where([
            ['application_type_id', '=', $applicationType->id],
            ['user_id', '=', $user->id],
            ['user_application_id', '=', $userApplication->id]
        ])->get();
        $positions = Position::all();
        return view('docs', compact('docs'))->with([
            'userApplication' => $userApplication,
            'positions' => $positions
        ]);
    }

    public function viewDoc(FacilityDocument $document)
    {
       /* $path = asset("storage/files/appdocs$document->document_file");
        return response()->withHeaders("");*/
        return view('viewDoc', compact('document'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param FacilityDocument $facilityDocument
     * @return void
     */
    public function show(FacilityDocument $facilityDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FacilityDocument $facilityDocument
     * @return Response
     */
    public function edit(FacilityDocument $facilityDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param FacilityDocument $facilityDocument
     * @return Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param FacilityDocument $facilityDocument
     * @return Response
     */
    public function destroy(FacilityDocument $facilityDocument)
    {
        //
    }
}
