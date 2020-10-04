<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\FacilityDocument;
use App\Position;
use App\User;
use App\UserApplication;
use Illuminate\Support\Facades\Storage;

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
//        return Storage::download('files/appdocs' . $document->document_file);
        return view('viewDoc', compact('document'));
    }

}
