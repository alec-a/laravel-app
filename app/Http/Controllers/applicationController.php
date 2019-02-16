<?php

namespace Lakeview\Http\Controllers;

use Lakeview\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class applicationController extends Controller
{
	
	public function __construct()
    {
		parent::__construct();
        $this->middleware('auth');
		$this->middleware('admin');
    }
	
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->pageData->currentUser = auth()->user()->name;
		$this->pageData->activeNav = 'applications';
		$this->pageData->applications = User::where('member','=',0)->get();
		return view('applications.index');
    }

    public function update(Request $request, User $user)
    {
        //
		if($request->changeStatus == 1 || $request->changeStatus == 3){
			$user->member = 1;
		}
		else{
			$user->member = 0;
		}
		
		$user->application_status = $request->changeStatus;
		$user->update();
		$user->age = Carbon::parse($user->birthday)->age;
		return json_encode($user);
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
	
	public function allForStatus(Request $request){
		$applications = User::where('application_status','=',$request->application_status)->get();
		
		foreach($applications as $application){
			$application->age = Carbon::parse($application->birthday)->age;
			$application->realCountry = $this->pageData->data->countries[$application->country];
		}
		
		return json_encode(['applications' => $applications, 'data' => $this->pageData->data]);
	}
}
