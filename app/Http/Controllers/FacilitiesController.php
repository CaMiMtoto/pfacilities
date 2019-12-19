<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\Category;
use App\Facility;
use App\FacilityDocument;
use App\Province;
use App\Service;
use App\UserApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (empty($search)) {
            $facilities = Facility::with(['category', 'service'])->paginate(10);
        } else {
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
        if ($request->id && $request->id > 0) {
            $cat = Facility::find($request->id);
        } else {
            $cat = new Facility();
        }
        $cat->name = $request->name;
        $cat->ref_number = $request->ref_number;
        $cat->email = $request->email;
        $cat->phone = $request->phone;
        $cat->manager_name = $request->manager_name;
        $cat->sector_id = $request->sector_id;
        $cat->user_id = Auth::id();
        $cat->category_id = $request->category_id;
        $cat->nationalId = $request->nationalId;
        $cat->service_id = $request->service_id;

        $license = $request->license_status;
        $cat->license_status = $license;
        if ($license == 'licensed') {
            $cat->license_issued_at = $request->license_issued_at;
            $cat->license_expires_at = $request->license_expires_at;
        } else if ($license == 'renew') {
            //upload docs
            $cat->app_letter = $this->uploadDoc($request->file('app_letter'));
            $cat->district_report = $this->uploadDoc($request->file('district_report'));
        }

        $cat->save();
//        return response($cat, 200);
        return redirect()->back()
            ->with([
                'message' => 'Saved'
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
        return response($facility, 200);
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

    public function addDocs(Request $request, Facility $facility)
    {
        foreach (array_keys($request->files->all()) as $array_key) {
            $fDoc = new FacilityDocument();
            $fDoc->facility_id = $facility->id;
            $fDoc->application_type_id = $request->applicationType;
            $fDoc->document_id = $array_key;
            $dir = 'public/files/appdocs';
            $file = $request->file("$array_key");
            $path = $file->store($dir);
            $fileName = str_replace("$dir", '', $path);
            $fDoc->document_file = $fileName;
            $fDoc->user_id = Auth::id();
            $fDoc->save();
        }

        $userApp = new UserApplication();
        $userApp->user_id = Auth::id();
        $userApp->application_type_id = $request->applicationType;
        $userApp->facility_id = $facility->id;
        $userApp->status = 'pending';
        $userApp->save();
        return redirect()->route('facilities');
    }
}
