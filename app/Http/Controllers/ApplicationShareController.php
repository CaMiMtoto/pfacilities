<?php

namespace App\Http\Controllers;

use App\ApplicationShare;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationShareController extends Controller
{

    public function index()
    {
        $applications = ApplicationShare::with(['userApplication','position'])
            ->where('position_id', '=', Auth::user()->position_id)
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.my_shared_applications', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ApplicationShare $applicationShare
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicationShare $applicationShare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ApplicationShare $applicationShare
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicationShare $applicationShare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ApplicationShare $applicationShare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicationShare $applicationShare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ApplicationShare $applicationShare
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationShare $applicationShare)
    {
        //
    }
}
