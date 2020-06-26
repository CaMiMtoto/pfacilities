<?php

namespace App\Http\Controllers;

use App\ApplicationApproval;
use App\ApplicationApprovalCarbonCopy;
use App\UserApplication;
use Illuminate\Http\Request;

class ApplicationApprovalController extends Controller
{
    public function create(UserApplication $application)
    {
        $application->load(['approvalLetter', 'applicationType', 'facility']);
//        return $application;
        return view('admin.manage_approval_letter', compact('application'));
    }

    public function store(Request $request, UserApplication $application)
    {
        $dir = 'public/files/signatures';
        $file = $request->file("signature");
        $path = $file->store($dir);
        $fileName = str_replace("$dir", '', $path);
        $app = ApplicationApproval::create([
            'user_application_id' => $application->id,
            'ref_number' => $request->input('ref_number'),
            'reason' => $request->input('reason'),
            'body' => $request->input('body'),
            'done_by' => $request->input('done_by'),
            'done_by_title' => $request->input('done_by_title'),
            'signature' => $fileName
        ]);


        $cc = $request->input('carbonCopies');
        foreach ($cc as $item) {
            ApplicationApprovalCarbonCopy::create([
                'application_approval_id' => $app->id,
                'name' => $item
            ]);
        }

        return redirect()->route('userApplication');
    }

    public function viewLetter(ApplicationApproval $approval)
    {
        $approval->load(['userApplication','carbonCopies']);
        return view('approval_letter', compact('approval'));
    }
}
