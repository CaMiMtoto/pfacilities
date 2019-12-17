<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{

    public function index()
    {
        $documents=Document::paginate('10');
        return view('admin.documents',compact('documents'));
    }


    public function store(Request $request)
    {
        if ($request->id && $request->id > 0) {
            $document = Document::find($request->id);
        } else {
            $document = new Document();
        }
        $document->name = $request->name;
        $document->save();
        return response()->json($document, 200);
    }

    public function show(Document $document)
    {
        return response()->json($document, 200);
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return response()->json(null, 200);
    }
}
