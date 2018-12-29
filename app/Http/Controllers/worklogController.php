<?php

namespace Lakeview\Http\Controllers;

use Lakeview\Worklog;
use Lakeview\Farm;
use Illuminate\Http\Request;

class worklogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Farm $farm)
    {
        dd($farm->fields->count());
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lakeview\Worklog  $worklog
     * @return \Illuminate\Http\Response
     */
    public function show(Worklog $worklog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Lakeview\Worklog  $worklog
     * @return \Illuminate\Http\Response
     */
    public function edit(Worklog $worklog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Lakeview\Worklog  $worklog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worklog $worklog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lakeview\Worklog  $worklog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worklog $worklog)
    {
        //
    }
}
