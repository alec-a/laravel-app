<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
	
	protected $fillable = [
        'name', 'owner'
    ];
	
    public function farmOwner(){
		return $this->belongsTo(User::class,'owner');
	}
	
	public function workers(){
		return $this->hasMany(User::class);
	}
	
	public function fields(){
		$fields = $this->hasMany(Fields::class)->orderByRaw('lpad(name, 10, 0)');
		return $fields;		
	}
	
	public function worklogs(){
		return $this->hasMany(Worklog::class, 'farm_id','id');
	}
	
	public function currentWorklog(){
		
		$rel = $this->hasOne(Worklog::class,'farm_id','id')->where('season', '=',$this->season);
	
		return $rel;
	}
	
	public function tasks(){
		return $this->hasMany(FarmTask::class,'farm_id','id');
	}
}
