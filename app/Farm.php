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
		return $this->hasMany(Fields::class);		
	}
	
	public function worklogs(){
		return $this->hasMany(Worklog::class);
	}
	
	public function currentWorklog(){
		return $this->hasMany(Worklog::class)->whereHas('farm', function($query){ $query->where('season', '=', $this->season); });
	}
}
