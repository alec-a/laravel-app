<?php

namespace Lakeview\Http\Controllers;

use Lakeview\User;
use Illuminate\Http\Request;

class userController extends Controller
{
	
	public function __construct() {
		parent::__construct();
		$this->middleware('auth');
		
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$this->pageData->activeNav = 'account';
		return view('account.index', ['pageData' => $this->pageData]);
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
     * @param  \Lakeview\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
		dd($user);
		
			return view('user.show',['pageData' => $this->pageData,'user' => $user]);
		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Lakeview\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Lakeview\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lakeview\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
