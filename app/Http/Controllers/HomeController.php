<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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

        if (Auth::user()->role != 'normal') {
            return view('home');
        }
        return redirect()->route('facilities');
    }

    public function viewDoc()
    {
        $path = request('path');
        return view('viewDocument', compact('path'));
    }
}
