<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class WorklogTaskComment extends Model
{
    public function worklogTask(){
		return $this->belongsTo(WorklogTask::class,'task_id');
	}
	
	public function author(){
		return $this->belongsTo(User::class,'user_id');
	}
}
