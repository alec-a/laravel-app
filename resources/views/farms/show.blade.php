@php extract((array)$pageData) @endphp
@extends('layouts.userArea')

@section('scripts')
<script src="{{asset('js/farms.js')}}"></script>
@endsection

@section('content')
<div id="farmId" data-farm-id="{{$farm->id}}"></div>
<div class="columns">
	<div class="column is-four-fifths has-text-left" id="farmName">
		<h1 class="title is-1 " >{{$farm->name}}</h1>
		<form method="post" class="hidden" action="{{url('/farms/'.$farm->id.'')}}">
			@csrf
			@method('put')
			<div class="field has-addons">
				<div class="control">
					<input type="text" name="farmName" value="" class="input is-1 is-large"/>
				</div>
				<div class="control">
					<button class="button is-large is-info" type="submit" id="saveFarmName">Save</button>
				</div>
				<div class="control">
					<p class="button is-large is-light" id="cancelRename">Cancel</p>
				</div>
			</div>
		</form>
	</div>
	<div class="column is-one-fifth has-text-right">
		@if(auth()->user()->id == $farm->owner  || auth()->user()->role == 1)
		<div class="dropdown">
			<div class="dropdown-trigger">
				<button class="button is-success" type="button" aria-haspopup="true" aria-controls="dropdown-menu1">
					<span>
					@if($user->id == $farm->owner)
					Owner
					@else
					Admin
					@endif
					</span>
					<span class="icon is-small"><i class="fas fa-angle-down" aria-hidden="true"></i></span>
				</button>
			</div>
			<div class="dropdown-menu" id="dropdown-menu1" role="menu">
				<div class="dropdown-content ">
					@if($user->farm_id != $farm->id && $user->id != $farm->owner)

					<form method='post' action='{{url('/farm/join/'.$farm->id)}}' id="joinFarm">
						@csrf
						@method('put')
						<div class='field'>
							<div class='control'>
								<a class="dropdown-item has-text-success has-text-centered" onclick="document.getElementById('joinFarm').submit()"><strong>Join Farm</strong></a>
							</div>
						</div>
					</form>
					@elseif($user->id != $farm->owner)
						<form method="post" action="{{url('farm/leave/'.$farm->id)}}" id="leave">
						@csrf
						@method('put')						
						<a class="dropdown-item has-text-centered" onclick="document.getElementById('leave').submit();">
							<strong>Leave Farm</strong>
						</a>
					</form>
					@endif
					<a class="dropdown-item is-bold has-text-centered" href="{{url('/farm/'.$farm->id.'/next-season')}}" id="season">
						<strong>Next Season</strong>
					</a>
					<hr class="dropdown-divider">
					<a class="dropdown-item is-bold has-text-centered has-text-info" id="rename">
						<strong>Re-Name Farm</strong>
					</a>
					<a class="dropdown-item has-text-danger has-text-centered" id="deleteFarm">
						<strong>Delete Farm</strong>
					</a>

				</div>
			</div>
		</div>
		@elseif(auth()->user()->farm_id == $farm->id)
		<div class="dropdown">
			<div class="dropdown-trigger">
				<button class="button is-warning" type="button" aria-haspopup="true" aria-controls="dropdown-menu1">
					<span>Worker</span>
					<span class="icon is-small"><i class="fas fa-angle-down" aria-hidden="true"></i></span>
				</button>
			</div>
			<div class="dropdown-menu" id="dropdown-menu1" role="menu">
				<div class="dropdown-content">
					
					<form method="post" action="{{url('farm/leave/'.$farm->id)}}" id="leave">
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


@if(auth()->user()->id == $farm->owner || auth()->user()->farm_id == $farm->id || auth()->user()->role == 1)
<div id="farmContentContainer">
	<div class="tabs is-boxed has-box-content">
		<ul>
			<li class="is-active">
				<a href="#info" data-tab="info">Info</a>
			</li>
			<li class="">
				<a href="#fields" data-tab="fields">Fields</a>
			</li>
			<li>
				<a href="#worklogs" data-tab="worklogs">Worklogs</a>
			</li>
			<li>
				<a href="#tasks" data-tab="tasks">Tasks</a>
			</li>
			<li>
				<a href="#stock" data-tab="stock">Stock</a>
			</li>
		</ul>
	</div>

	<div class="box is-radiusless-top tab-container">
		
		@include('farms.tabs.info')
		@include('farms.tabs.fields')
		@include('farms.tabs.worklogs')
		@include('farms.tabs.tasks')
		@include('farms.tabs.stock')

	</div>
</div>
@else
<div class='columns'>
	<div class="column is-two-thirds top">
		<form method='post' action='{{url('/farm/join/'.$farm->id)}}'>
			@csrf
			@method('put')
			<div class='field'>
				<div class='control'>
					<button type="submit" class="button is-info is-large is-fullwidth is-outlined"><strong>Join Farm</strong></button>
				</div>
			</div>
		</form>
	</div>
</div>
@endif
@endsection
