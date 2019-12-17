<?php

namespace App\Http\Controllers;

use App\Category;
use App\District;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function summary(){
        $districts=District::all();
        $categories=Category::all();
        return view('admin.reports.summary',compact('districts'))
            ->with(['categories'=>$categories]);
    }
}
