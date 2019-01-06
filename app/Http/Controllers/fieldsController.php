<?php

namespace Lakeview\Http\Controllers;

use Lakeview\Fields;
use Lakeview\Farm;
use Lakeview\Task;
use Lakeview\WorklogField;
use Lakeview\WorklogTask;
use Illuminate\Http\Request;

class fieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	
	
	public function __construct() {
		parent::__construct();
	}
	
    public function index(Request $request)
    {
        $server = $request->server();
		$farmId = intval(str_replace($server['HTTP_ORIGIN'].'/farm/', '', $server['HTTP_REFERER']));
		$farm = Farm::find($farmId);
		
		$this->output->status = 'success';
		
		$fields = empty($request->trashed)? $farm->fields:$farm->fields()->onlyTrashed()->get();
		foreach($fields as $field){
			$field->crop;
		}
		$this->output->response->fields = $fields;
		
		$this->output = json_encode($this->output);
		
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
		
		$validator = \Validator::make($request->all(),[
			'fieldName' => 'required'
		]);
		if($validator->fails()){
			$this->output->status = 'fail';
			$this->output->errors = $validator->errors()->all();
		}
		else{
			$server = $request->server();
			$farmId = intval(str_replace($server['HTTP_ORIGIN'].'/farm/', '', $server['HTTP_REFERER']));
			$farm = Farm::find($farmId);
			$fieldData['name'] = $request->fieldName;
			$fieldData['crop_id'] = 1;
			$fieldData['farm_id'] = $farmId;
			
			

			$field = Fields::create($fieldData);
			if($field->exists){
				
				
				if($farm->worklogs->count() > 0 && !empty($farm->currentWorklog))
				{
					
					$worklogField = new WorklogField;
					$worklogField->worklog_id = $farm->currentWorklog->id;
					$worklogField->field_id = $field->id;
					$worklogField->crop_id = $field->crop_id;
					$worklogField->save();
					
					$tasks = Task::all();
					foreach($tasks as $task){
						$worklogTask = new WorklogTask;
						$worklogTask->worklog_id = $farm->currentWorklog->id;
						$worklogTask->worklog_field_id = $worklogField->id;
						$worklogTask->task_id = $task->id;
						$worklogTask->save();
					}
				}
				$this->output->response->fields = $farm->fields;
				$field->crop;
				$this->output->response->field = $field;
				$this->output->status = 'success';
				
			}
			else{
				
				
				$this->output->errors[]="Field Could Not Be Created";
				
			}
		}
		
		if(isset($this->ajax)){
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
     * @param  \Lakeview\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function show(Fields $fields)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Lakeview\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function edit(Fields $fields)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Lakeview\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fields $fields)
    {
		$server = $request->server();
		$farmId = intval(str_replace($server['HTTP_ORIGIN'].'/farm/', '', $server['HTTP_REFERER']));
		$farm = Farm::find($farmId);
		$validator = \Validator::make($request->all(),[
			'fieldName' => 'required'
		]);
		if($validator->fails()){
			$this->output->status = 'fail';
			$this->output->errors = $validator->errors()->all();
		}
		else{
			$fields->name = $request->fieldName;
			if($fields->save()){
				$this->output->status = 'success';
				$this->output->response->crop = $fields->crop;
				$this->output->response->field = $fields;
			}
			$this->output->errors[]="Field Could Not Be Saved";
		}
		if($this->ajax){
			$farmId = intval(str_replace($server['HTTP_ORIGIN'].'/farm/', '', $server['HTTP_REFERER']));
			$farm = Farm::find($farmId);
			$this->output->response->fields = $farm->fields;
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
     * @param  \Lakeview\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Fields $fields)
    {
		$field = $fields;
		if($fields->delete()){
			$this->output->status = 'success';
			$this->output->response = $field;
		}
		
        if(isset($request->ajax)){
			$this->output = json_encode($this->output);
		}
		else{
			$this->output = back();
		}
		
		
		
		return $this->output;
    }
	
	public function delete(Request $request){
		$fields = json_decode($request->fields);
		
		foreach($fields as $field){
			
			$farmField = Fields::onlyTrashed()->find($field->id);
			$farmField->forceDelete();
		}
	}
	
	public function restore(Request $request){
		$fields = json_decode($request->fields);
		
		foreach($fields as $field){
			
			$farmField = Fields::onlyTrashed()->find($field->id);
			$farmField->restore();
		}
	}
	
	public function trash(Request $request){
		$fields = json_decode($request->fields);
		
		foreach($fields as $field){
			$farmField = Fields::find($field->id);
			$farmField->delete();
		}
	}
}
