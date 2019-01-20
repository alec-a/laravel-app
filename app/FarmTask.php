<?php

namespace Lakeview;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FarmTask extends Model
{
    //
	
	use SoftDeletes;
	
	protected $guarded = [];
	
	public function getColour(){
		switch($this->status){
			default:
				$this->bgColour = 'grey-lighter';
				$this->txtColour = 'black';
				break;
			case 1:
				$this->bgColour = 'info';
				$this->txtColour = 'light';
				break;
			case 2:
				$this->bgColour = 'warning';
				$this->txtColour = 'grey-dark';
				break;
			case 3:
				$this->bgColour = 'success';
				$this->txtColour = 'light';
				break;
			
		}
		return $this;
	}
}
