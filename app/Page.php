<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
   public function children(){
		return $this->hasMany( 'Lakeview\Page', 'parent', 'id' );
	}

	public function parent(){
	  return $this->hasOne( 'Lakeview\Page', 'id', 'parent' );
	}
}
