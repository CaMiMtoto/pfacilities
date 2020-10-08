<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $sql = "select count(f.id) as value, c.name as label from facilities f inner join categories c on f.category_id = c.id group by c.name";
        $facilitiesByCategory = DB::select($sql);
        $values = collect($facilitiesByCategory)->pluck('value');
        $labels = collect($facilitiesByCategory)->pluck('label');
        if (Auth::user()->role != 'normal') {
            return view('home', compact('values', 'labels'));
        }
        return redirect()->route('facilities');
    }

    public function viewDoc()
    {
        $path = request('path');
        return view('viewDocument', compact('path'));
    }
}
