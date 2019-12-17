<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessApplication;
use App\Jobs\ProcessUserApplication;
use App\UserApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApplicationController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'verifier') {
            $userApps = UserApplication::with([
                'applicationType',
                'user'
            ])->orderByDesc('id')
                ->paginate(10);
        } elseif (Auth::user()->role == 'inspector') {
            $userApps = UserApplication::with([
                'applicationType',
                'user'
            ])->where('status', 'verified')
                ->orderByDesc('id')
                ->paginate(10);
        } else {
            $userApps = UserApplication::with('applicationType')
                ->where('user_id', Auth::id())->get();
        }
        return view('user_applications', compact('userApps'));
    }

    public function show(UserApplication $userApplication)
    {
        return response()->json($userApplication, 200);
    }


    public function updateReview(Request $request, UserApplication $userApplication)
    {
        $userApplication->status = $request->status;
        $userApplication->comment = $request->comment;
        $userApplication->update();
        return response(null, 204);
    }

    public function changeStatus(Request $request, UserApplication $application)
    {
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
