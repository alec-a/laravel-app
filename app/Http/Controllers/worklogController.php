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
		$farm->fields;
		$this->output->response->user = auth()->user();
		$this->output->response->farm = $farm;
		$this->output->response->farm->worklogs = $request->has('trashed')? $farm->worklogs()->orderBy('id','desc')->onlyTrashed()->get():$farm->worklogs()->orderBy('id','desc')->get();
		if($this->ajax){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = view('worklog.index');
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
				$createField = array('field_id' => $field->id, 'crop_id' => 1);
				$wlField = $worklog->fields()->create($createField);
				foreach($tasks as $task){
					$createTask = array('worklog_field_id'=>$wlField->id,'task_id' => $task->id, 'worklog_id' => $worklog->id);
					$wlField->tasks()->create($createTask);
				}
			}			
		}
		
		
		if($this->ajax){
			$farm->worklogs()->orderBy('id','desc')->get();
			$this->output->status = 'success';
			$this->output->response->user = auth()->user();
			$this->output->response->farm = $farm;
			$this->output->response->worklog = $worklog;
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
		$tasks = Task::all();
		$this->pageData->farm = $farm;
		$this->pageData->worklog = $worklog;
		$this->pageData->tasks = $tasks;
//		$this->pageData->priorityTasks = WorklogTask::where('worklog_id','=',$worklog->id)->where('status','=',1)->orderBy('priority','desc')->get();
//		$this->pageData->requiredTasks = WorklogTask::where('worklog_id','=',$worklog->id)->where('status','=',1)->orderBy('task_id','desc')->get();
//		$this->pageData->completedTasks = WorklogTask::where('worklog_id','=',$worklog->id)->where('status','=',3)->orderBy('task_id','desc')->get();
		
		/**
		 * Ajax should have a task_id it wants to fetch tasks for
		 */
		if(!empty($request->task_id)){
			//get a worklogTask by id
			$worklogTask = $worklog->tasks->where('id', '=',$request->task_id)->first();
			$worklogTask->info;
			$worklogTask->completedUser;
			$worklogTask->field;
			$worklogTask->field->info;
			$worklogTask->worklog;
			
			$worklogTask->getColour();
			$this->output->response->worklogTask = $worklogTask;
			$this->output->response->crops = \Lakeview\Crops::all();
			
		}
		
		if(!empty($request->task)){
			//get All worklogTasks for the task id
			$wlTasks = $worklog->tasks->where('task_id', '=',$request->task);
			$worklogTasks = array();
			$fieldName = array();
			$i=0;
			foreach($wlTasks as $wlTask){
				$wlTask->field->info;
				$wlTask->field->crop;
				$wlTask->getColour();
				$worklogTasks[$i] = $wlTask;
				$fieldName[$i] = $wlTask->field->info->name;
				$cropType[$i] = $wlTask->field->crop->name;
				$i++;
			}

			$sortFlag = SORT_ASC;
			$sortArray = $fieldName;
			switch($request->sortBy){
				case 0:
					$sortArray = $fieldName;
				break;
				case 1:
					$sortArray = $cropType;
				break;
			}
			switch($request->sortDir){
				case 0:
					$sortFlag = SORT_ASC;
				break;
				case 1:
					$sortFlag = SORT_DESC;
				break;
			}
			
			array_multisort($sortArray, $sortFlag, $worklogTasks);
			$this->output->response->worklogTasks = $worklogTasks;
			$this->output->response->crops = \Lakeview\Crops::all();
		}
		
		if(!empty($request->tabColours)){
			$taskTabClasses = array();
			$taskTabIcons = array();
			foreach($tasks as $task){
				$requiredTasks = $worklog->tasks()->where('task_id', '=',$task->id)->where('status', '=','1')->get();
				$progressTasks =  $worklog->tasks()->where('task_id', '=',$task->id)->where('status', '=','2')->get();
				$completedTasks =  $worklog->tasks()->where('task_id', '=',$task->id)->where('status', '=','3')->get();
				$noteTasks = $worklog->tasks()->where([['task_id', '=',$task->id],['status','<','3']])->whereRaw('note <> ""')->get();
				if($progressTasks->count() > 0){
					$taskTabClasses[$task->id] = 'has-text-warning-dark has-text-weight-bold';
				}
				elseif($requiredTasks->count() > 0 ){
					$taskTabClasses[$task->id] = 'has-text-info has-text-weight-bold';
				}
				elseif($completedTasks->count() > 0){
					$taskTabClasses[$task->id] = 'has-text-success';
				}
				else{
					$taskTabClasses[$task->id] = '';
				}
				if($noteTasks->count() > 0 ){
					$taskTabIcons[$task->id] = '<span class="icon"><i class="fas fa-sticky-note"></i></span>';
				}else{
					$taskTabIcons[$task->id] = '';
				}
			}
			$this->output->response->tabClasses = $taskTabClasses;
			$this->output->response->tabIcons = $taskTabIcons;
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
    public function update(Request $request, Farm $farm, Worklog $worklog)
    {
        $this->output->status = 'success';
		
		$worklog->name = $request->name;
		$worklog->save();
		
		$worklogs = Worklog::all();
		$user = auth()->user();
		
		if($this->ajax){
			$farm->worklogs()->orderBy('id','desc')->get();
			$this->output->response->worklog = $worklog;
			$this->output->response->user = $user;
			$this->output->response->farm = $farm;
			
			$this->output = json_encode($this->output);
		}
		else
		{
			$this->output = back();
		}
		return $this->output;
    }
	
	public function trash(Request $request, Farm $farm, Worklog $worklog)
    {
        $this->output->status = 'success';
		
		$farm->fields;
		$worklog->delete();
		
		
		$user = auth()->user();
		
		if($this->ajax){
			$this->output->response->user = $user;
			$this->output->response->farm = $farm;
			$this->output->response->farm->worklogs = $farm->worklogs()->orderBy('id','desc')->get();
			$this->output = json_encode($this->output);
		}
		else
		{
			$this->output = back();
		}
		return $this->output;
    }

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lakeview\Worklog  $worklog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Farm $farm, $worklog)
    {
        $this->output->status = 'success';
		$deleteWorklog = Worklog::withTrashed()->findOrFail($worklog);
		$deleteWorklog->deleteAll();
    }
	
	public function restore(Request $request, Farm $farm, $worklog)
    {
		$trashedWorklog = Worklog::withTrashed()->findOrFail($worklog);
		$trashedWorklog->restore();
        $this->output->status = 'success';
		$this->output->worklog = $trashedWorklog;
		$this->output = json_encode($this->output);
    }
}
