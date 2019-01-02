<?php

namespace Lakeview\Http\Controllers;

use Lakeview\WorklogTask;
use Lakeview\Farm;
use Illuminate\Http\Request;

class worklogTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Lakeview\WorklogTask  $worklogTask
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Farm $farm, WorklogTask $worklogTask)
    {

		$this->pageData->task = $worklogTask;
//		$this->pageData->priorityTasks = WorklogTask::where('worklog_id','=',$worklog->id)->where('status','=',1)->orderBy('priority','desc')->get();
//		$this->pageData->requiredTasks = WorklogTask::where('worklog_id','=',$worklog->id)->where('status','=',1)->orderBy('task_id','desc')->get();
//		$this->pageData->completedTasks = WorklogTask::where('worklog_id','=',$worklog->id)->where('status','=',3)->orderBy('task_id','desc')->get();
		

		
			$worklogTask->info;
			$worklogTask->field;
			$worklogTask->completedUser;
			$worklogTask->field->info;
			$worklogTask->worklog;
			$worklogTask->getColour();
			$this->output->response->worklogTask = $worklogTask;
		
		
		$this->output->status = 'success';
		
		if($this->ajax){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = view('worklog.show')->render();
		}
		
		return $this->output;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Lakeview\WorklogTask  $worklogTask
     * @return \Illuminate\Http\Response
     */
    public function edit(WorklogTask $worklogTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Lakeview\WorklogTask  $worklogTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Farm $farm, WorklogTask $worklogTask)
    {
		if($this->ajax){
			if(isset($request->taskStatus) && $request->taskStatus >= 0 && $request->taskStatus <= 3){
				$date = new \DateTime('NOW');
				
				$worklogTask->completed_by_id = ($request->taskStatus == 3)? auth()->user()->id:null;
				$worklogTask->completed_on = ($request->taskStatus == 3)? $date->format('Y-m-d G:i:s'):null;
				$worklogTask->status = $request->taskStatus;
				$worklogTask->save();
				$worklogTask->info;
				$worklogTask->completedUser;
				$worklogTask->field;
				$worklogTask->field->info;
				$worklogTask->worklog;
				$worklogTask->getColour();
				return json_encode($worklogTask);
			}
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lakeview\WorklogTask  $worklogTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorklogTask $worklogTask)
    {
        //
    }
}
