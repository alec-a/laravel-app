<?php

namespace Lakeview\Http\Controllers;

use Lakeview\WorklogTask;
use Lakeview\Field;
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
			if(!empty($request->cropId)){
				$worklogTask->field()->update([
					'crop_id' => $request->cropId
				]);
			}
			
			if(!empty($request->option)){
				if($request->option == 'null'){
					$request->option = '';
				}
				$worklogTask->update([
					'task_option' => $request->option
				]);
			}
			
			if(!is_null($request->updateNote)){
				$this->output->response = $request->note;
				$worklogTask->update([
					'note' => $request->note
				]);
				
				return json_encode($this->output);
			}
			
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
				
				//if the task is plant(tasks.id = 6) update the farm field crop and if the planter had fert find the task for fertilizing that is required for the field
				
				if($worklogTask->task_id == 6){
											
					$worklogTask->field->info()->update(['crop_id' => $request->taskStatus == 3? $worklogTask->field->crop_id:1]);
					$worklogTask->field()->update(['is_planted' => $request->taskStatus == 3? true:false]);
					
					//search for the two fertilizer tasks for this field
					
					
					if($request->taskStatus == 3){
						$fertTasks = WorklogTask::where('worklog_field_id','=',$worklogTask->field->id)->where(function($q){$q->where('task_id','=',1)->orWhere('task_id','=',2); })->orderBy('task_id','ASC')->get();
						$updated = false;
						foreach($fertTasks as $fertTask)
						{
							if($fertTask->status < 3 && $worklogTask->task_option == 1 && !$updated){
								$now = now();
								$fertTask->update(['status' => 3, 'completed_on' => $now, 'completed_by_id' => auth()->user()->id]);
								$updated = true;
							}
							
						}
					}
					else{
						$fertTasks = WorklogTask::where('worklog_field_id','=',$worklogTask->field->id)->where(function($q){$q->where('task_id','=',1)->orWhere('task_id','=',2); })->orderBy('task_id','DESC')->get();
						
						$updated = false;
						foreach($fertTasks as $fertTask)
						{
							if($fertTask->status == 3 && $worklogTask->task_option == 1 && !$updated){
								$now = now();
								$fertTask->update(['status' => 1, 'completed_on' => null, 'completed_by_id' => null]);
								$updated = true;
							}
							
						}
					}
					
					
				}elseif($worklogTask->task_id == 8){
						if($request->taskStatus == 3){
							$worklogTask->field->info()->update(['crop_id' => 1]);
						}else{
							$worklogTask->field->info()->update(['crop_id' => $worklogTask->field->crop_id]);
						}
				}
				else
				{
					$worklogTask->field->info()->update(['crop_id' => $worklogTask->field->crop_id]);
				}
				
				
				
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
