<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
	protected $dateFormat = 'Y-m-d H:i:s';
	protected $guarded = ['id'];
	protected $dates = ['closed_at','re_opened_at'];
    public function version(){
		return $this->belongsTo(Version::class);
	}
	public function author(){
		return $this->belongsTo(User::class,'user_id','id');
	}
	public function closedBy(){
		return $this->belongsTo(User::class,'close_id','id');
	}
	public function reOpenedBy(){
		return $this->belongsTo(User::class,'re_open_id','id');
	}
	
}
