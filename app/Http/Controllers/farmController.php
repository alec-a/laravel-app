<?php

namespace Lakeview\Http\Controllers;

use Lakeview\Farm;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;

class farmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct()
    {
		parent::__construct();
        $this->middleware('auth');
    }
	
    public function index()
    {
        $this->pageData->activeNav = 'farms';
		$this->pageData->farms = Farm::all();
		return view('farms.index',['pageData' => $this->pageData]);
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
		/*ajax*/
		$userId = auth()->id();
		$farmData['name'] = $request->farmName;
		$farmData['owner'] = $userId;
		$farm = Farm::create($farmData);
        if(isset($request->ajax)){
			return view('farms.store', ['farm' => $farm])->render();
		}
		else
		{
			return back();
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lakeview\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function show(Farm $farm)
    {
        $this->pageData->activeNav = 'farms';
		$this->pageData->farm = $farm;
		return view('farms.show',['pageData' => $this->pageData]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Lakeview\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function edit(Farm $farm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Lakeview\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Farm $farm)
    {
        
		
		$farm->name = $request->name;
		$farm->save();
		return back();
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lakeview\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Farm $farm)
    {
        $farm->delete();
		return redirect(url('/farms'));
    }
	
	public function join(Farm $farm)
    {
        $user = \Lakeview\User::find(auth()->user()->id);
		$user->farm_id = $farm->id;
		$user->save();
		return back();
    }
	
	public function leave(Farm $farm)
	{
		$user = \Lakeview\User::find(auth()->user()->id);
		$user->farm_id = null;
		$user->save();
		return back();
	}
}
