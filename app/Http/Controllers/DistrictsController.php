<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;

class DistrictsController extends Controller
{
    public function districtsByProvince($id){
        return response(District::where('province_id','=',$id)->get(),200);
    }
}
