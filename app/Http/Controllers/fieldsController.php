<?php

namespace Lakeview\Http\Controllers;

use Lakeview\Fields;
use Lakeview\Farm;
use Illuminate\Http\Request;

class fieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
		
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
		$server = $request->server();
		$farmId = intval(str_replace($server['HTTP_ORIGIN'].'/farms/', '', $server['HTTP_REFERER']));
		$fieldData = array(
			'name' => $request->name,
			'crop_id' => intval($request->crop_id),
			'farm_id' => $farmId
		);
		
		$field = Fields::create($fieldData);
		
		
		
        return view('fields.store',['field' => $field])->render();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lakeview\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function show(Fields $fields)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Lakeview\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function edit(Fields $fields)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Lakeview\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fields $fields)
    {
		if(isset($request->ajax)){
			$return = new \stdClass();
			$return->status = 'fail';
		
			$fields->name = $request->name;
			$fields->crop_id = intval($request->crop_id);
			if($fields->save()){
				$return->status = 'success';
				$return->response = $fields;
				$return->response->crop = $fields->crop;
			}
			else{
				$return->error = "Unable To Save Changes";
			}
			
			return json_encode($return);
		}
		
       else{
		   return back();
	   }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lakeview\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fields $fields)
    {
        //
    }
}
