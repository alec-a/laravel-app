@extends('layouts.userArea')

@section('content')
@if(auth()->user()->id == $pageData->farm->owner)
<div class="modal" id="deleteModal">
	<form method="post" action="{{url('/farms/'.$pageData->farm->id)}}">
	@csrf
	@method('DELETE')
	</form>
  <div class="modal-background"></div>
  <div class="modal-card ">
    <header class="modal-card-head has-background-danger">
      <p class="modal-card-title has-text-white">Delete Farm</p>
      
    </header>
    <section class="modal-card-body">
		<p class="title is-4"><strong>Are You Sure You Want To Delete Your Farm?</strong></p>
		<div class="field is-grouped">
			<div class="control">
				<button class="button is-danger is-large" id="deleteYes">Yes</button>
			</div>
			<div class="control">
				<button class="button is-info is-large" id="deleteNo">No</button>
			</div>
		</div>
		
      
    </section>
  </div>
</div>
@endif
<div class="columns">
	<div class="column is-four-fifths has-text-left" id="farmName">
		<h1 class="title is-1 " >{{$pageData->farm->name}}</h1>
		<form method="post" class="hidden" action="{{url('/farms/'.$pageData->farm->id.'')}}">
			@csrf
			@method('put');
			<div class="field has-addons">
				<div class="control">
					<input type="text" name="name" value="" class="input is-1 is-large"/>
				</div>
				<div class="control">
					<button class="button is-large is-info">Save</button>
				</div>
				<div class="control">
					<p class="button is-large is-light" id="cancelRename">Cancel</p>
				</div>
			</div>
		</form>
	</div>
	<div class="column is-one-fifth has-text-right">
		@if(auth()->user()->id == $pageData->farm->owner)
		<div class="dropdown">
			<div class="dropdown-trigger">
				<button class="button is-success" type="button" aria-haspopup="true" aria-controls="dropdown-menu1">
					<span>Owner</span>
					<span class="icon is-small"><i class="fas fa-angle-down" aria-hidden="true"></i></span>
				</button>
			</div>
			<div class="dropdown-menu" id="dropdown-menu1" role="menu">
				<div class="dropdown-content ">	
					<a class="dropdown-item is-bold has-text-centered has-text-info" id="rename">
						<strong>Re-name Farm</strong>
					</a>
					<a class="dropdown-item has-text-danger has-text-centered" id="delete">
						<strong>Delete Farm</strong>
					</a>
				</div>
			</div>
		</div>
		@elseif(auth()->user()->farm_id == $pageData->farm->id)
		<div class="dropdown">
			<div class="dropdown-trigger">
				<button class="button is-warning" type="button" aria-haspopup="true" aria-controls="dropdown-menu1">
					<span>Worker</span>
					<span class="icon is-small"><i class="fas fa-angle-down" aria-hidden="true"></i></span>
				</button>
			</div>
			<div class="dropdown-menu" id="dropdown-menu1" role="menu">
				<div class="dropdown-content">
					
					<form method="post" action="{{url('farms/leave/'.$pageData->farm->id)}}" id="leave">
						@csrf
						@method('put')						
						<a class="dropdown-item" onclick="document.getElementById('leave').submit();">
							Leave Farm
						</a>
					</form>
				</div>
			</div>
		</div>
		
		@endif
	</div>
</div>

<div class='columns'>
	@if(auth()->user()->id == $pageData->farm->owner || auth()->user()->farm_id == $pageData->farm->id)
	
	<div class="column">
		<div class="tile is-ancestor">
			<div class="tile is-vertical is-8">
			  <div class="tile">
				<div class="tile is-parent is-vertical">
					 <article class="tile is-child notification is-info">
					<p class="title">Info</p>
					<p class="">Season: {{$pageData->farm->season}}</p>
					<p class="">Owner: {{$pageData->farm->farmOwner->name}}</p>
				  </article>
				  <article class="tile is-child notification is-warning">
					<p class="title">Members</p>
					<p class="subtitle">{{$pageData->farm->workers->count()}}</p>
					
					<ul>
					@foreach($pageData->farm->workers as $worker)
						<li>{{$worker->name}}</li>						
					@endforeach
					</ul>
				  </article>
				</div>
				<div class="tile is-parent">
					<article class="tile is-child notification is-success">
					  <p class="title">Worklogs</p>
					</article>
				</div>
			  </div>
			</div>
			<div class="tile is-parent">
			  <article class="tile is-child notification is-link">
				<div class="content">
				  <p class="title">Discussion</p>
				  <p class="subtitle">With even more content<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test<BR/>test</p>
				  <div class="content">
					<!-- Content -->
				  </div>
				</div>
			  </article>
			</div>
		</div>
	</div>
	
	
	
	@else
	
	<div class="column is-two-thirds top">
		<form method='post' action='{{url('/farms/join/'.$pageData->farm->id)}}'>
			@csrf
			@method('put')
			<div class='field'>
				<div class='control'>
					<button type="submit" class="button is-info is-large is-fullwidth is-outlined"><strong>Join Farm</strong></button>
				</div>
			</div>
		</form>
	</div>
	
	@endif
</div>
@endsection
