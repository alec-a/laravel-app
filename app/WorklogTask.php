<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class WorklogTask extends Model
{
	protected $guarded = ['id','created_at','updated_at'];
	public function worklogField(){
		return $this->hasOne(WorklogField::class,'field_id','field_id')->where('worklog_id', '=', 'worklog_id');
	}
	
	public function worklogID(){
		return $this->belongsTo(WorklogTask::class,'worklog_id','worklog_id');
	}
	
	public function info(){
		return $this->hasOne(Task::class,'id','task_id');
	}
	
	public function field(){
		return $this->hasOne(Fields::class,'id','field_id');
	}
	
}
