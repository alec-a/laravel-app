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
   
	
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	
	public function __construct() {
		parent::__construct();
		$this->middleware('auth');
		$this->pageData->activeNav = 'farms';
		$uri = request()->server('PATH_INFO');
		$this->ajax = strpos($uri, 'ajax');
	}
	/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Farm $farm)
    {
		$this->pageData->farm = $farm;
		$this->output->status = 'success';
		
		$this->output->response->farm = $farm;
		if($this->ajax){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = view('worklog.index')->with('dangerMsg',"This Is Still Under Development And May Be Broken But It's Here To Look At!");
		}
		return $this->output;
    }

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Farm $farm)
    {
		$this->pageData->farm = $farm;
		$this->message = "There is a worklog for this season, creating a new one will overwite the current worklog!";
        if($this->ajax){
			$this->pageData->farm = $farm;
			$this->output->status = 'success';
			$this->output->response = !empty($farm->currentWorklog)? view('worklog.modals.create')->with('warningMsg',$this->message)->render(): view('worklog.modals.create')->render();
		}
		else{
			$this->output = (!empty($farm->currentWorklog))? view('worklog.create')->with('warningMsg',$this->message):$this->output = view('worklog.create');	
		}
		return $this->output;
    }

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Farm $farm)
    {
		$tasks = Task::all();
		
		if(!empty($farm->currentWorklog)){
			$farm->currentWorklog->delete();
		}
		
		$worklogattrs['farm_id'] = $farm->id;
		$worklogattrs['name'] = (empty($request->name)? null:$request->name);
		$worklogattrs['season'] = $farm->season;
		
		$worklog = Worklog::create($worklogattrs);
        if($worklog->exists()){
			
			foreach($farm->fields as $field){
				$createField = array('field_id' => $field->id, 'crop_id' => $field->crop_id);
				$wlField = $worklog->fields()->create($createField);
				foreach($tasks as $task){
					$createTask = array('worklog_field_id'=>$wlField->id,'task_id' => $task->id, 'worklog_id' => $worklog->id);
					$wlField->tasks()->create($createTask);
				}
			}			
		}
		
		
		if($this->ajax){
			$this->output->status = 'success';
			$this->output->response = $worklog;
			$this->output = json_encode($this->output);
		}
		else
		{
			$this->output = redirect('/farm/'.$worklog->farm_id)->with('success','Created Worklog <strong>'.$worklog->name.'</strong> for Season <strong>'.$worklog->season.'</strong>');
		}
		return $this->output;
    }

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	
    /**
     * Display the specified resource.
     *
     * @param  \Lakeview\Worklog  $worklog
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Farm $farm, Worklog $worklog)
    {
		$task = Task::all();
		$this->pageData->worklog = $worklog;
		$this->pageData->tasks = $task;
//		$this->pageData->priorityTasks = WorklogTask::where('worklog_id','=',$worklog->id)->where('status','=',1)->orderBy('priority','desc')->get();
//		$this->pageData->requiredTasks = WorklogTask::where('worklog_id','=',$worklog->id)->where('status','=',1)->orderBy('task_id','desc')->get();
//		$this->pageData->completedTasks = WorklogTask::where('worklog_id','=',$worklog->id)->where('status','=',3)->orderBy('task_id','desc')->get();
		
		/**
		 * Ajax should have a task_id it wants to fetch tasks for
		 */
		if(!empty($request->task_id)){
			//get worklogTasks for this id
			$worklogTask = $worklog->tasks->where('id', '=',$request->task_id)->first();
			$worklogTask->info;
			$worklogTask->field;
			$worklogTask->field->info;
			$worklogTask->worklog;
			$worklogTask->getColour();
			$this->output->response->worklogTask = $worklogTask;
			
		}
		
		$this->output->status = 'success';
		
		if($this->ajax){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = view('worklog.show')->render();
		}
		
		return $this->output;
    }

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	
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

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	
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

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	
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
