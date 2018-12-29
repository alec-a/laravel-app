<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class WorklogTask extends Model
{
    public function worklogField(){
		return $this->hasOne(WorklogField::class,'field_id','field_id')->where('worklog_id', '=', 'worklog_id');
	}
	
	public function field(){
		return $this->hasOne(Fields::class,'id','field_id');
	}
	
}
