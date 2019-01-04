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
		//$this->output = back();
		$validator = \Validator::make($request->all(),[
			'farmName' => 'required|min:5'
		]);
		
		if($validator->fails()){
			$this->output->status = 'fail';
			$this->output->errors = $validator->errors()->all();
		}
		else{
			$farmData['name'] = $request->farmName;
			$farmData['owner'] = auth()->user()->id;
			$farm = Farm::create($farmData);
			if($farm->exists){
				$this->output->status = 'success';
				$this->output->response = view('farms.store', ['farm' => $farm])->render();
			}
			else
			{
				$this->output->errors[]="Farm Could Not Be Created";
			}
		}
		
		if(isset($request->ajax)){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = back()->withErrors($validator->errors()->all());
		}
				
		return $this->output;
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
        $validator = \Validator::make($request->all(),[
			'farmName' => 'required|min:5'
		]);
		
		if($validator->fails()){
			$this->output->status = 'fail';
			$this->output->errors = $validator->errors()->all();
		}
		else{
		
			$farm->name = $request->farmName;
			$farm->save();
		
			if($farm->exists()){
				$this->output->status = 'success';
				$this->output->response = $farm;
			}
		}
		
		if(isset($request->ajax)){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = back()->withErrors($validator->errors()->all());
		}
				
		return $this->output;
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
	
	public function nextSeason(Request $request, Farm $farm){
		$currentSeason = $farm->season;
		$farm->season = $currentSeason+1;
		$farm->save();
		$this->output->status = 'success';
		$this->output->response = $farm;
		
		if($this->ajax){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = back();
		}
		return $this->output;
	}
}
