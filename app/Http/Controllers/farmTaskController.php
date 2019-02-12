<?php

namespace Lakeview\Http\Controllers;

use Lakeview\FarmTask;
use Lakeview\Farm;
use Illuminate\Http\Request;

class farmTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        parent::__construct();
    }

    public function index(Request $request, Farm $farm)
    {
		$this->pageData->farm = $farm;
		
		$this->output->status = 'success';
		$farm->fields;
		$this->output->response->user = auth()->user();
		$this->output->response->farm = $farm;
		$this->output->response->farmTasks = array();
		$tasks =  $request->has('trashed')? $farm->tasks()->onlyTrashed()->orderBy('id','desc')->get():$farm->tasks()->orderBy('id','desc')->get();
		foreach($tasks as $task){
			$task->getColour();
			$this->output->response->farmTasks[] = $task;
		}
		
		if($this->ajax){
			$this->output = json_encode($this->output);
		}
		else{
			//$this->output = view('worklog.index');
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
    public function store(Request $request, Farm $farm)
    {
		$request['farm_id'] = $farm->id;
        $newTask = FarmTask::create($request->only('title','content','farm_id','status'));
		
		$this->output->status = 'success';
		$newTask->getColour();
		$this->output->response->farmTask = $newTask;
		
		
		if($this->ajax){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = $newTask;
		}
			
		
		return $this->output;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lakeview\FarmTask  $farmTask
     * @return \Illuminate\Http\Response
     */
    public function show(FarmTask $farmTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Lakeview\FarmTask  $farmTask
     * @return \Illuminate\Http\Response
     */
    public function edit(FarmTask $farmTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Lakeview\FarmTask  $farmTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Farm $farm, FarmTask $farmTask)
    {
        if($this->ajax){
			$this->output->status = 'success';
			
			if(!is_null($request['status'])){
				$farmTask->status = $request['status'];
				$farmTask->save();
			}
			else{
				$farmTask->update($request->only('title','content'));
			}
			$farmTask->getColour();
			$this->output->response->farmTask = $farmTask;
			
			$this->output = json_encode($this->output);
		}
		
		
		return $this->output;
    }

	
	public function trash(Request $request, Farm $farm, FarmTask $farmTask)
    {
        $this->output->status = 'success';
		$farmTask->delete();
		
		
		if($this->ajax){
			
			$this->output->response->farmTasks = $farm->tasks()->orderBy('id','desc')->get();
			$this->output = json_encode($this->output);
		}
		else
		{
			$this->output = back();
		}
		return $this->output;
    }
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lakeview\FarmTask  $farmTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Farm $farm, $farmTask)
    {
        $this->output->status = 'success';
		$deleteTask = FarmTask::withTrashed()->findOrFail($farmTask);
		$deleteTask->forceDelete();
    }
	
	public function restore(Request $request, Farm $farm, $farmTask)
    {
		$trashedTask = FarmTask::withTrashed()->findOrFail($farmTask);
		$trashedTask->restore();
        $this->output->status = 'success';
		$this->output->farmTask = $trashedTask;
		$this->output = json_encode($this->output);
    }
}
