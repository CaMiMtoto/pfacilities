<?php

namespace App\Http\Controllers;

use App\ApplicationShare;
use App\ApplicationType;
use App\Category;
use App\Facility;
use App\FacilityDocument;
use App\FacilityService;
use App\Jobs\ProcessShareApplication;
use App\Notifications\NewUserApplication;
use App\Position;
use App\Province;
use App\Service;
use App\UserApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class FacilitiesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $services = Service::all();
        $provinces = Province::all();
        $appTypes = ApplicationType::all();

        $search = $request->input('q');
        if (empty($search)) {
            $facilities = Facility::with(['category', 'service'])->where([
                ['user_id', '=', Auth::id()]
            ])->paginate(10);
        } else {
            $facilities = Facility::with(['category', 'service'])
                ->where([
                    ['user_id', '=', Auth::id()]
                ])
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('manager_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('nationalId', 'LIKE', "%{$search}%")
                ->paginate(10);

            $facilities->appends(['q' => $search]);
        }

        return view('facility', compact('facilities'))
            ->with(['services' => $services, 'categories' => $categories, 'provinces' => $provinces, 'appTypes' => $appTypes]);
    }

    public function adminFacilities(Request $request)
    {
        $categories = Category::all();
        $services = Service::all();
        $provinces = Province::all();
        $search = $request->input('q');
//now()->diffInDays()
        if (\request('licensed')) {
            $facilities = Facility::with(['category', 'service'])
                ->where([
                    ['license_issued_at', '!=', null],
                    ['license_expires_at', '!=', null],
                ])->paginate(10);
        } elseif (\request('expiring_soon')) {
            $facilities = Facility::with(['category', 'service'])
                ->where([
                    ['license_expires_at', '<=', Carbon::now()->addDays(30)->toDateTimeString()],
                ])->paginate(10);
        }  elseif (\request('expired')) {
            $facilities = Facility::with(['category', 'service'])
                ->where([
                    ['license_expires_at', '<', Carbon::now()->toDateTimeString()],
                ])->paginate(10);
        } elseif (empty($search)) {
            $facilities = Facility::with(['category', 'service'])->paginate(10);
        } elseif ($search) {

            $facilities = Facility::with(['category', 'service'])
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('manager_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('nationalId', 'LIKE', "%{$search}%")
                ->paginate(10);
            $facilities->appends(['q' => $search]);
        }
        return view('facility', compact('facilities'))
            ->with(['services' => $services, 'categories' => $categories, 'provinces' => $provinces]);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        $editMode = true;
        $message = "Facility successfully";
        if ($request->id && $request->id > 0) {
            $facility = Facility::find($request->id);
            $message = $message . " updated";
        } else {
            $facility = new Facility();
            $editMode = false;
            $message = $message . " saved";
        }
        $facility->name = $request->name;
        $facility->ref_number = $request->ref_number;
        $facility->email = $request->email;
        $facility->phone = $request->phone;
        $facility->manager_name = $request->manager_name;
        $facility->sector_id = $request->sector_id;
        $facility->user_id = Auth::id();
        $facility->category_id = $request->category_id;
        $facility->nationalId = $request->nationalId;
//        $facility->service_id = $request->service_id;

        $facility->other_service = $request->other_service;
        $owner = $request->input('owner');
        $facility->owner = $owner;
        $facility->position = $request->position;
        $facility->cell_id = $request->input('cell_id');
        $facility->plot_number = $request->input('plot_number');
        $facility->other_services = $request->other_services;

        $license = $request->license_status;
        $facility->license_status = $license;
        if ($license == 'licensed') {
            $facility->license_issued_at = $request->license_issued_at;
            $facility->license_expires_at = $request->license_expires_at;
        } else {
            $facility->license_issued_at = null;
            $facility->license_expires_at = null;
        }
        if ($license == 'renew') {
            //upload docs
            $facility->app_letter = $this->uploadDoc($request->file('app_letter'));
            $facility->district_report = $this->uploadDoc($request->file('district_report'));
        }
        if ($owner == 'Facility owner') {
            $facility->facility_owner = $owner;
        } else {
            $facility->facility_owner = $request->input('facility_owner');
        }

        $facility->save();
        $services = $request->input('service_id');
        if ($services) {
            $facility->facilityServices()->delete();
            foreach ($services as $service) {
                FacilityService::create([
                    'facility_id' => $facility->id,
                    'service_id' => $service,
                ]);
            }
        }
        DB::commit();
        return redirect()->back()
            ->with([
                'success' => $message,
            ]);
    }


    private function uploadDoc($file)
    {
        $dir = 'public/files/facilitydocs/';
        $path = $file->store($dir);
        return str_replace("$dir", '', $path);
    }

    public function show(Facility $facility)
    {
        return response($facility->load('facilityServices'), 200);
    }

    public function edit(Facility $facility)
    {
        $obj = $facility->load(['facilityServices', 'sector.district.province']);
        $facilityServices = FacilityService::with('facility')->where('facility_id', '=', $facility->id)
            ->pluck('service_id');

        return view('admin.edit_facility', [
            'facility' => $obj,
            'categories' => Category::all(),
            'provinces' => Province::all(),
            'services' => Service::all(),
            'facility_services' => $facilityServices
        ]);
    }


    public function updateLicence(Request $request, Facility $facility)
    {
        $facility->license_issued_at = $request->license_issued_at;
        $facility->license_expires_at = $request->license_expires_at;
        $facility->update();
        return redirect()->route('adminFacilities');
    }


    public function destroy(Facility $facility)
    {
        $facility->delete();
        return response(null, 204);
    }

    /*   public function addDocs(Request $request, Facility $facility)
       {
           $userApp = new UserApplication();
           $userApp->user_id = Auth::id();
           $userApp->application_type_id = $request->applicationType;
           $userApp->facility_id = $facility->id;
           $userApp->status = 'pending';
           $userApp->save();

           foreach (array_keys($request->files->all()) as $array_key) {
               $fDoc = new FacilityDocument();
               $fDoc->facility_id = $facility->id;
               $fDoc->application_type_id = $request->applicationType;
               $fDoc->user_application_id = $userApp->id;
               $fDoc->document_id = $array_key;
               $dir = 'public/files/appdocs';
               $file = $request->file("$array_key");
               $path = $file->store($dir);
               $fileName = str_replace("$dir", '', $path);
               $fDoc->document_file = $fileName;
               $fDoc->user_id = Auth::id();
               $fDoc->save();
           }


           return redirect()->route('facilities');
       }

   */


    public function saveNewApplication(Request $request)
    {
//        dd($request->all());
        DB::beginTransaction();
        try {
            $facility = Facility::find($request->facility_id);

            $appId = 0;
            $app = UserApplication::latest()->first();
            if ($app)
                $appId = $app->id + 1;

            $userApp = new UserApplication();
            $userApp->user_id = \auth()->id();
            $userApp->application_type_id = $request->applicationType;
            $userApp->facility_id = $facility->id;
            $userApp->status = 'pending';
            $userApp->application_id = now()->format('dmy') . $appId;
            $userApp->save();

            foreach (array_keys($request->files->all()) as $array_key) {
                $fDoc = new FacilityDocument();
                $fDoc->facility_id = $facility->id;
                $fDoc->application_type_id = $request->applicationType;
                $fDoc->user_application_id = $userApp->id;
                $fDoc->document_id = $array_key;

                $dir = 'public/files/appdocs';
                $file = $request->file("$array_key");
                $path = $file->store($dir);
                $fileName = str_replace("$dir", '', $path);
                $fDoc->document_file = $fileName;
                $fDoc->user_id = Auth::id();
                $fDoc->save();
            }

            $appShare = new ApplicationShare();

            $appShare->user_application_id = $userApp->id;
            $position = Position::with('users')->where('name', '=', Position::$PHF);
            $appShare->position_id = $position->first()->id;
            $appShare->shared_by = \auth()->id();
            $appShare->save();
            DB::commit();

            //TODO notify other users about new application which are in pending status
            $users = $position->first()->users()->get();
//            return $users;

            $load = $appShare->load(['userApplication', 'position', 'sharedBy']);
            Notification::send($users, new NewUserApplication($load));

            ProcessShareApplication::dispatch($load);

            return redirect()->back()->with([
                'success' => 'New application successfully saved'
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with([
                'error' => $exception->getMessage()
            ]);
        }
    }
}
