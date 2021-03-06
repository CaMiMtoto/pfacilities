<?php

namespace App\Http\Controllers;

use App\ApplicationHistory;
use App\ApplicationShare;
use App\ApplicationType;
use App\CertificatePicking;
use App\Facility;
use App\FacilityDocument;
use App\Jobs\ProcessApplication;
use App\Jobs\ProcessShareApplication;
use App\Jobs\ProcessUserApplication;
use App\Notifications\NewUserApplication;
use App\Position;
use App\User;
use App\UserApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class UserApplicationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        if ($filter == 'all') {
            $filter = '';
        }
        $user = auth()->user();
        if ($user->role == 'normal') {
            $userApps = UserApplication::with(['applicationType', 'facility', 'user','approvalLetter'])
                ->where([
                    ['user_id', '=', \auth()->id()],
                ])
                ->orderBy('status')
                ->paginate(10);
        } else {
            $userApps = UserApplication::with([
                'applicationType',
                'user', 'approvalLetter'
            ])->where('status', 'LIKE', "%$filter%")
                ->orderByDesc('id')
                ->paginate(10);
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
        if (!$userApplication->sharedToMe())
            return response("Not allowed", 400);
        $position_id = $request->position_id;
        $status = $request->status;
        $comment = $request->comment;
        $id = Auth::id();
        $appShare = ApplicationShare::where([
            ['user_application_id', '=', $userApplication->id],
        ])->first();
        if ($appShare == null) {
            $appShare = new ApplicationShare();
        }
        $appShare->user_application_id = $userApplication->id;
        $appShare->position_id = $position_id;
        $appShare->shared_by = $id;
        $appShare->save();
        if ($position_id) {
            $appHistory = new ApplicationHistory();
            $appHistory->shared_to_position_id = $position_id;
            $appHistory->shared_by = $id;
            $appHistory->status = $status;
            $appHistory->comment = $comment;
            $userApplication->history()->save($appHistory);
        }

        // TODO notify application for modification


        $userApplication->status = $status;
        $userApplication->comment = $comment;
        $userApplication->update();
        if ($status == 'approved' && Auth::user()->role == 'minister') {
            $userApplication->facility->license_issued_at = now();
            $userApplication->facility->license_expires_at = now()->addYears(2);
            $userApplication->facility->update();
        }


        $load = $appShare->load(['userApplication', 'position', 'sharedBy']);
        ProcessShareApplication::dispatch($load);

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

    public function makeAppointment(Request $request, UserApplication $application)
    {
        $certificate = new CertificatePicking();

        $time = $request->input('picking_date') . " " . $request->input('time') . ":00";
//           return response($time,400);
        $certificate->picking_date = $time;
        $application->status = 'signed';
        $certificate->user_application_id = $application->id;
        $certificate->save();
        $application->update();

        return response($application, 200);
    }

    public function appAppointments(Request $request)
    {
        $appointments = CertificatePicking::with('userApplication')
            ->orderByDesc('id')
            ->paginate(10);
        return view('appointments', compact('appointments'));
    }

    public function pickCertificate(Request $request, CertificatePicking $picking)
    {
        $picking->picked_by = $request->input('picked_by');
        $picking->nid = $request->input('nid');
        $picking->comment = $request->input('comment');
        $picking->picked_at = now();
        $picking->save();
        return $picking;
    }

    public function applicationHistories(UserApplication $application)
    {
        $application = $application->load(['history', 'facility']);
//        return $histories;
        return view('application_history', compact('application'));
    }

    public function updateApplication(Request $request, UserApplication $application)
    {
        DB::beginTransaction();
        $facility_id = $request->input('facility_id');
        $facility = Facility::find($facility_id);
        if ($facility == null)
            throw new NotFoundResourceException("Facility not found");
        try {
            $userId = \auth()->id();
            $application->user_id = $userId;
            $applicationType = $request->input('applicationType');
            $application->application_type_id = $applicationType;
            $application->facility_id = $facility_id;
            $application->status = 'pending';
            $application->update();

            $position = Position::with('users')->where('name', '=', 'Phf');
            $positionId = $position->first()->id;
            $appShare = ApplicationShare::where([
                ['user_application_id', '=', $application->id],
                ['position_id', '=', $positionId],
                ['shared_by', '=', $userId],
            ])->first();
            if ($appShare == null)
                $appShare = new ApplicationShare();
            $appShare->user_application_id = $application->id;
            $appShare->position_id = $positionId;
            $appShare->shared_by = $userId;
            $appShare->save();
            $allFiles = $request->files->all();
            if (count($allFiles) > 0) {
                $application->FacilityDocuments()->delete();
            }
            foreach (array_keys($allFiles) as $array_key) {
                $facilityDocument = new FacilityDocument();
                $facilityDocument->facility_id = $facility->id;
                $facilityDocument->application_type_id = $applicationType;
                $facilityDocument->user_application_id = $application->id;
                $facilityDocument->document_id = $array_key;
                $dir = 'public/files/appdocs';
                $file = $request->file("$array_key");
                $path = $file->store($dir);
                $fileName = str_replace("$dir", '', $path);
                $facilityDocument->document_file = $fileName;
                $facilityDocument->user_id = $userId;
                $facilityDocument->save();
            }

            DB::commit();

            $users = $position->first()->users()->get();
            $load = $appShare->load(['userApplication', 'position', 'sharedBy']);

            Notification::send($users, new NewUserApplication($load));

            ProcessShareApplication::dispatch($load);

            return redirect()->back()->with([
                'success' => 'Application successfully updated'
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with([
                'error' => $exception->getMessage()
            ]);
        }
    }
}
