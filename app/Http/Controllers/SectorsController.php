<?php

namespace App\Http\Controllers;

use App\District;
use App\Sector;
use Illuminate\Http\Request;

class SectorsController extends Controller
{

    public function sectorsByDistrict($id){
        return response(Sector::where('district_id','=',$id)->get(),200);
    }
}
