<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\ApplicationTypeDocument;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationTypeController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        $applicationTypes = ApplicationType::paginate(10);
        return view('admin.applicationTypes', compact('applicationTypes'))
            ->with(['documents' => $documents]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->id && $request->id > 0) {
                $app = ApplicationType::find($request->id);
            } else {
                $app = new ApplicationType();
            }
            $app->name = $request->name;
            $app->save();
            foreach ($request->input('documents') as $document) {
                $appDoc = new ApplicationTypeDocument();
                $appDoc->document_id = $document;
                $appDoc->application_type_id = $app->id;
                $appDoc->user_id = Auth::id();
                $appDoc->save();
            }
            DB::commit();

            return response()->json($app, 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(null, 404);
        }
    }

    public function update(Request $request, ApplicationType $app)
    {
        DB::beginTransaction();
        try {
            $app->name = $request->input('name');
            $app->save();
            $app->applicationTypeDocuments()->delete();
            $documents = $request->input('documents');
            if ($documents > 0) {
                foreach ($documents as $document) {
                    $appDoc = new ApplicationTypeDocument();
                    $appDoc->document_id = $document;
                    $appDoc->application_type_id = $app->id;
                    $appDoc->user_id = \auth()->id();
                    $appDoc->save();
                }
            }

            DB::commit();
            return redirect()->route('app-types.all')->with('success', " Application type ($app->name) Successfully updated");
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function show(ApplicationType $applicationType)
    {
        return response()->json($applicationType, 200);
    }

    public function destroy(ApplicationType $applicationType)
    {
        try {
            $applicationType->delete();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', 'Application type deleted');
    }


    public function appTypeDocs($id)
    {
        $appTypeDocs = ApplicationTypeDocument::with('document')->where('application_type_id', $id)->get();
        return view('apps_docs', compact('appTypeDocs'));
    }

    public function edit(ApplicationType $type)
    {
        $applicationTypeDocuments = $type->applicationTypeDocuments()->get();
        $documents = Document::all();
        return view('admin.edit_application_type', compact('type'))
            ->with(['documents' => $documents, 'applicationTypeDocuments' => $applicationTypeDocuments->pluck('document_id')]);
    }


}
