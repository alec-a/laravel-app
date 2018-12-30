<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worklog extends Model
{
	use SoftDeletes;
	
	protected $dates = ['deleted_at'];
	
	protected $guarded = ['id','created_at','updated_at'];
	public function tasks(){
		return $this->hasMany(WorklogTask::class, 'worklog_id', 'id');
	}
	public function fields(){
		return $this->hasMany(WorklogField::class, 'worklog_id','id');
	}
	
	public function farm(){
		return $this->belongsTo(Farm::class);
	}
	
	public function current()
	{
		return $this->where('season','=', $this->farm->season)->take(1);
	}
}
