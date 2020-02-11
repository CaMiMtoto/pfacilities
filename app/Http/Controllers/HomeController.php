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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role != 'normal') {
            return redirect()->route('summary');
        }
        return view('home');
    }

    public function viewDoc()
    {
        $path = $_GET['path'];
        return view('viewDocument', compact('path'));
    }
}
