@extends('layouts.userArea')

@section('content')
<div class="hidden" id="farmId"><input type="hidden" name="id" value="{{$pageData->farm->id}}"/></div>
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
					<a class="dropdown-item is-bold has-text-centered" id="fields">
						<strong>Add Fields</strong>
					</a>
					<a class="dropdown-item is-bold has-text-centered" id="season">
						<strong>Next Season</strong>
					</a>
					<hr class="dropdown-divider">
					<a class="dropdown-item is-bold has-text-centered has-text-info" id="rename">
						<strong>Re-name Farm</strong>
					</a>
					<a class="dropdown-item has-text-danger has-text-centered" id="deleteFarm">
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
	
	<div class="column is-one-third">
		<div class="box is-fullheight has-text-weight-bold">
		<h3 class="title is-3">Info</h3>
		<p>Season: {{$pageData->farm->season}}</p>
		<p>Owner: {{$pageData->farm->farmOwner->name}}</p>
		</div>
	</div>
	<div class="column is-one-third">
		<div class="box is-fullheight has-text-weight-bold">
		<h3 class="title is-3">Members</h3>
		<p class="subtitle">{{$pageData->farm->workers->count()}}</p>
			@foreach($pageData->farm->workers as $worker)
				<li>{{$worker->name}}</li>						
			@endforeach
		</ul>
		</div>
	</div>
	<div class="column is-one-third">
		<div class="box is-fullheight has-text-weight-bold">
		<h3 class="title is-3">Worklogs</h3>
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
