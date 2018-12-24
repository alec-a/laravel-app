<?php

namespace Lakeview\Http\Controllers;

use Lakeview\Page;
use Illuminate\Http\Request;

class pageController extends Controller
{
	public function __construct() {
		parent::__construct();
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return view('welcome',['pageData' => $this->pageData]);
       
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Lakeview\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show($uri ='/',$uri1=null,$uri2=null)
    {
		if(!empty($uri1)){
			if(!empty($uri2)){
				$page = Page::where('uri','=', $uri2)->firstOrFail();
				$this->pageData->page = $page;
				$parent = $page->parent()->first();
				return isset($parent->uri)&&$parent->uri == $uri1? view('layouts.page',['pageData' => $this->pageData]): abort(404);
			}
			else{
				$page = Page::where('uri','=', $uri1)->firstOrFail();
				$this->pageData->page = $page;
				$parent = $page->parent()->first();
				return isset($parent->uri)&&$parent->uri == $uri? view('layouts.page',['pageData' => $this->pageData]): abort(404);
			}
		}
		else{
			$page = Page::where('uri','=', $uri)->firstOrFail();
			$this->pageData->page = $page;
			$parent = $page->parent()->first();
			
			if(isset($parent->uri)){
				
				return $parent->uri == '/'? view('layouts.page',['pageData' => $this->pageData]): abort(404);
			}
			elseif ($uri == '/') {
				return view('layouts.page',['pageData' => $this->pageData]);
			}
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Lakeview\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Lakeview\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Lakeview\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }
}
