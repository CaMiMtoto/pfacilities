<?php

namespace App\Http\Controllers;

use App\ApplicationApproval;
use App\Signature;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    public function signature()
    {
        return view('admin.signature', [
            'signature' => auth()->user()->signature
        ]);
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $dir = 'public/files/signatures';
        $file = $request->file("signature");
        $fileName = '';
        if ($file) {
            $path = $file->store($dir);
            $fileName = str_replace("$dir", '', $path);
        }
        $id = $request->input('id');
        if ($id != null && $id > 0) {
            $sign = Signature::find($id);
        } else {
            $sign = new Signature();
        }
        $sign->user_id = auth()->id();
        $sign->file_name = $fileName;
        $sign->save();
        return redirect()->back()->with('success','Signature successfully saved');
    }
}
