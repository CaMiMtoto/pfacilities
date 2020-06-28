<?php

namespace App\Http\Controllers;

use App\ApplicationApproval;
use App\ApplicationApprovalCarbonCopy;
use App\UserApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApplicationApprovalController extends Controller
{
    public function create(UserApplication $application)
    {
        $application->load(['approvalLetter', 'applicationType', 'facility']);
        return view('admin.manage_approval_letter', compact('application'))
            ->with(['approvalLetter' => $application->approvalLetter, 'isRequired' => $application->approvalLetter ? false : true]);
    }

    public function store(Request $request, UserApplication $application)
    {
        $id = $request->input('id');
        if ($id != null && $id > 0) {
            $app = ApplicationApproval::find($id);
        } else {
            $app = new ApplicationApproval();
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
        $app->done_by = $request->input('done_by');
        $app->done_by_title = $request->input('done_by_title');

        $app->save();


        $cc = $request->input('carbonCopies');
        if (count($cc) > 0) {
            $app->carbonCopies()->delete();
            foreach ($cc as $item) {
                if ($item) {
                    ApplicationApprovalCarbonCopy::create([
                        'application_approval_id' => $app->id,
                        'name' => $item
                    ]);
                }
            }
        }
        if($app->signed_at!=null){
            $application->status='signed';
            $application->update();
        }
        return redirect()->route('userApplication');
    }

    public function viewLetter(ApplicationApproval $approval)
    {
        $approval->load(['userApplication', 'carbonCopies','user.signature']);
//        return  $approval;
        return view('approval_letter', compact('approval'));
    }
}
