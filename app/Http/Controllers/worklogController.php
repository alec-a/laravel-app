<?php

namespace Lakeview\Http\Controllers;

use Lakeview\Worklog;
use Lakeview\Farm;
use Lakeview\Task;
use Lakeview\WorklogField;
use Lakeview\WorklogTask;
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
    public function create(Farm $farm)
    {
		$this->pageData->farm = $farm;
		
        if($this->ajax){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = view('worklog.create',['pageData'=>$this->pageData])->render();
		}
		
		return $this->output;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Farm $farm)
    {
		$tasks = Task::all();
		$worklogattrs['farm_id'] = $farm->id;
		$worklogattrs['name'] = (empty($request->name)? null:$request->name);
		$worklogattrs['season'] = $farm->season;
				
		$worklog = Worklog::create($worklogattrs);
        if($worklog->exists()){
			$fieldsattrs = array();
			
			foreach($farm->fields as $field){
				$fieldsattrs[] = array(
					'worklog_id' => $worklog->id,
					'field_id' => $field->id,
					'crop_id' => 0);
				$taskattrs = array();
				
				foreach($tasks as $task){
				$taskattrs[] = array(
					'worklog_id' => $worklog->id,
					'field_id' => $field->id,
					'task_id' => $task->id);
				}
				$worklogTasks = WorklogTask::insert($taskattrs);
			}
			
			
			
			$worklogFields = WorklogField::insert($fieldsattrs);
			
		}
		
		return json_encode($worklog);
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
