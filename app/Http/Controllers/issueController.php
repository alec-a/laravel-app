<?php

namespace Lakeview\Http\Controllers;

use Lakeview\Issue;
use Illuminate\Http\Request;

class issueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct() {
		parent::__construct();
		$this->pageData->activeNav='dashboard';
		$this->middleware('auth');
	}


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
		
        return view('issue.create',['pageData' => $this->pageData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $version = $this->pageData->version;
		$user = auth()->user();
		
		$attributes = request()->validate(['title' => 'required','content'=>'required']);
		$attributes['version_id'] = $version->id;
		$attributes['user_id'] = $user->id;
		$attributes['open'] = true;
		Issue::create($attributes);
		return redirect(url('/dashboard'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lakeview\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Lakeview\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
		$this->pageData->issue = $issue;
        return view('issue.edit',['pageData' => $this->pageData]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Lakeview\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
		$date = new \DateTime('NOW');
        if($request->re_open){
			$issue->re_open = 1;
			$issue->open = 1;
			$issue->re_open_id = auth()->user()->id;
			$issue->re_opened_at = $date->format('Y-m-d G:i:s');
		}
		elseif($request->close){
			$issue->re_open = 0;
			$issue->open = 0;
			$issue->close_id = auth()->user()->id;
			$issue->closed_at = $date->format('Y-m-d G:i:s');
		}
		else{
			request()->validate(['title' => 'required','content'=>'required']);
			$issue->title = $request->title;
			$issue->content = $request->content;
		}
		
		$issue->save();
		return redirect(url('/dashboard'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lakeview\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $issue->delete();
		return back();
    }
}
