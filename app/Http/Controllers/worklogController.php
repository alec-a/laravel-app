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
	public function __construct() {
		parent::__construct();
		$this->middleware('auth');
		$this->pageData->activeNav = 'farms';
		$uri = request()->server('PATH_INFO');
		$this->ajax = strpos($uri, 'ajax');
	}
	
    public function index(Request $request, Farm $farm)
    {
		$this->pageData->farm = $farm;
		$this->output->status = 'success';
		$this->output->response = new \stdClass();
		$this->output->response->farm = $farm;
		
		if($this->ajax){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = view('worklog.index',['pageData'=>$this->pageData])->render();
		}
		
		return $this->output;
		
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
    public function show(Farm $farm, Worklog $worklog)
    {
		$this->pageData->worklog = $worklog;
		$this->output->status = 'success';
		$this->output->response = $worklog;
		
		if($this->ajax){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = view('worklog.show', ['pageData' => $this->pageData])->render();
		}
		
		return $this->output;
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
