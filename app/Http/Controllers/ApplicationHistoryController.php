<?php

namespace App\Http\Controllers;

use App\ApplicationHistory;
use Illuminate\Http\Request;

class ApplicationHistoryController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * public function create()
     * {
     * //
     * }
     *
     * /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function show(ApplicationHistory $applicationHistory)
    {
        return $applicationHistory;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ApplicationHistory $applicationHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicationHistory $applicationHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ApplicationHistory $applicationHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicationHistory $applicationHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ApplicationHistory $applicationHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationHistory $applicationHistory)
    {
        //
    }
}
