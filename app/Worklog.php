<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class Worklog extends Model
{
    public function tasks(){
		return $this->hasMany(WorklogTask::class, 'worklog_id', 'id');
	}
	public function fields(){
		return $this->hasMany(WorklogField::class, 'worklog_id','id');
	}
	
	public function farm(){
		return $this->belongsTo(Farm::class);
	}
}
