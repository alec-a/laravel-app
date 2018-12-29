<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class WorklogField extends Model
{
	protected $guarded = ['id', 'created_at','updated_at'];
	public function tasks(){
		
		return $this->hasMany(WorklogTask::class,'field_id','field_id')->whereHas('worklogID', function($query){ $query->where('worklog_id', '=', $this->worklog_id);});
	}
	public function crop(){
		return $this->hasOne(Crops::class,'id','crop_id');
	}
	public function info(){
		return $this->belongsTo(Fields::class,'field_id');
	}
}
