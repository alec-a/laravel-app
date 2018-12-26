<?php

namespace Lakeview\Http\Controllers;

use Illuminate\Http\Request;
use Lakeview\Farm;

class modalController extends Controller
{
    public function farms(Request $request){
		$farm = Farm::where('id',$request->farmId)->first();
		
			
		return view($request->controller.'.modals.'.$request->name,['farmId' => $farm->id])->render();
		
	}
}
