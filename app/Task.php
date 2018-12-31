<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function worklogTasks(){
		return $this->hasMany(WorklogTask::class,'task_id','id');
	}
}
