<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class WorklogField extends Model
{
    public function tasks(){
		return $this->hasMany(WorklogField::class,'field_id','field_id')->where('worklog_id', '=', 'worklog_id');
	}
	public function crop(){
		return $this->hasOne(Crops::class,'id','crop_id');
	}
}
