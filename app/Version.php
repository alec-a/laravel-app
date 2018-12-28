<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    public function issues(){
		return $this->hasMany(Issue::class);
	}
	
}
