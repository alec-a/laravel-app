<?php

namespace Lakeview\Http\Controllers;

use Illuminate\Http\Request;
use Lakeview\Farm;
use Lakeview\Fields;
use Lakeview\Worklog;

class modalController extends Controller
{
	public function index(){
		return view('modalBuild');
	}
	
    public function farms(Request $request){
		$farm = Farm::where('id',$request->farmId)->first();
		$editWorklog = null;
		if(!empty($request->worklogId)){
			$editWorklog = Worklog::find($request->worklogId);
		}
		return view($request->controller.'.modals.'.$request->name,['farmId' => $farm->id,'farm'=>$farm,'editWorklog' => $editWorklog])->render();
	}
	
	public function field(Request $request){
		
		$field = Fields::where('id',$request->fieldId)->first();
		return view($request->controller.'.modals.'.$request->name,['fieldId' => $field->id, 'farmId' => $field->farm_id])->render();
	}
}
