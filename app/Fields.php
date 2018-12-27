<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
	
	protected $guarded = [
		'id','created_at','updated_at'
	];

    public function farm(){
		return $this->belongsTo(Farm::class);	
	}
	
	public function crop(){
		return $this->hasOne(Crops::class,'id','crop_id');
	}
}
