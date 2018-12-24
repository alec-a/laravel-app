<?php

namespace Lakeview\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->pageData->activeNav = 'dashboard';
        return view('dashboard',['pageData' => $this->pageData]);
    }
}
