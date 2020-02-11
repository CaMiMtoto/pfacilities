<?php

namespace App\Http\Controllers;

use App\ApplicationShare;
use App\ApplicationType;
use App\Facility;
use App\Jobs\ProcessApplication;
use App\Jobs\ProcessUserApplication;
use App\User;
use App\UserApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApplicationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        if ($filter == 'all') {
            $filter = '';
        }
        if (Auth::user()->role == 'normal') {
            $userApps = UserApplication::with([
                'applicationType',
                'facility',
                'user'
            ])->where('user_id', Auth::id())->paginate(10);
        } else {
            $userApps = UserApplication::with([
                'applicationType',
                'user'
            ])->where('status', 'LIKE', "%$filter%")->orderByDesc('id')->paginate(10);
        }
        $userApps->appends(['filter' => $filter]);
        $facilities = Facility::with('category')->where("user_id", Auth::id())->get();
        $appTypes = ApplicationType::all();

        return view('user_applications', compact('userApps'))
            ->with([
                'facilities' => $facilities,
                'appTypes' => $appTypes
            ]);
    }

    public function show(UserApplication $userApplication)
    {
        return response()->json($userApplication, 200);
    }


    public function updateReview(Request $request, UserApplication $userApplication)
    {
            $appShare = new ApplicationShare();
            $appShare->user_application_id = $userApplication->id;
            $appShare->position_id = $request->position_id;
            $appShare->shared_by=Auth::id();
            $appShare->save();

        $userApplication->status = $request->status;
        $userApplication->comment = $request->comment;
        $userApplication->update();
        if ($request->status=='approved' && Auth::user()->role=='mos'){
            $userApplication->facility->license_issued_at=now();
            $userApplication->facility->license_expires_at=now()->addYears(2);
            $userApplication->facility->update();
        }
        return response(null, 204);
    }

    public function changeStatus(Request $request, UserApplication $application)
    {
        $users = User::where('role', 'inspector')->get();
        $users = $users->each(function ($user) {
            return $user->email;
        });
//        return response($users, 200);

        if (Auth::user()->role == 'inspector' && $application->status == 'verified') {
            if ($request->status == 'approved') {
                $application->status = 'inspected';
            } else {
                $application->status = 'received';
            }
        } else if (Auth::user()->role == 'approval' && $application->status == 'inspected') {
            if ($request->status == 'approved') {
                $application->status = 'approved';
            } else {
                $application->status = 'verified';
            }
        } else if (Auth::user()->role == 'certifier' && $application->status == 'approved') {
            if ($request->status == 'approved') {
                $application->status = 'certified';
            } else {
                $application->status = 'inspected';
            }
        }


        $application->update();
        ProcessApplication::dispatch($application->load('user'));
        ProcessUserApplication::dispatch($application->load('user'));

        return redirect()->back();
//        return response($application, 204);
    }
}
