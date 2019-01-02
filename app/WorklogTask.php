<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class WorklogTask extends Model
{
	protected $guarded = ['id','created_at','updated_at'];
		
	public function info(){
		return $this->belongsTo(Task::class,'task_id');
	}
	
	public function field(){
		return $this->belongsTo(WorklogField::class,'worklog_field_id');
	}
	
	public function worklog(){
		return $this->belongsTo(Worklog::class,'worklog_id');
	}
	
	public function completedUser(){
		return $this->belongsTo(User::class,'completed_by_id');
	}
	
	public function getColour(){
		switch($this->status){
			default:
				$this->bgColour = 'grey-lighter';
				$this->txtColour = 'black';
				break;
			case 1:
				$this->bgColour = 'info';
				$this->txtColour = 'light';
				break;
			case 2:
				$this->bgColour = 'warning';
				$this->txtColour = 'grey-dark';
				break;
			case 3:
				$this->bgColour = 'success';
				$this->txtColour = 'light';
				break;
			
		}
		return $this;
	}
	
}
