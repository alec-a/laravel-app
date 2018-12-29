<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fields extends Model
{
	use SoftDeletes;
	
	protected $guarded = [
		'id','created_at','updated_at'
	];
	
	protected $dates = ['deleted_at'];

    public function farm(){
		return $this->belongsTo(Farm::class);	
	}
	
	public function crop(){
		return $this->hasOne(Crops::class,'id','crop_id');
	}
}
