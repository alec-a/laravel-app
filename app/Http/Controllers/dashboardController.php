<?php

namespace Lakeview\Http\Controllers;

use Illuminate\Http\Request;
use Lakeview\Version;
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
		$this->pageData->versions = Version::orderBy('id', 'desc')->take(3)->get();
		//dd($this->pageData->versions);
        return view('dashboard',['pageData' => $this->pageData]);
    }
	
}
