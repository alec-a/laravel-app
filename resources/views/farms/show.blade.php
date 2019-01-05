@php extract((array)$pageData) @endphp
@extends('layouts.userArea')

@section('scripts')
<script src="{{asset('js/farms.js')}}"></script>
@endsection

@section('content')
<div class="hidden" id="farmId"><input type="hidden" name="id" value="{{$farm->id}}"/></div>
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
		@if(auth()->user()->id == $farm->owner)
		<div class="dropdown">
			<div class="dropdown-trigger">
				<button class="button is-success" type="button" aria-haspopup="true" aria-controls="dropdown-menu1">
					<span>Owner</span>
					<span class="icon is-small"><i class="fas fa-angle-down" aria-hidden="true"></i></span>
				</button>
			</div>
			<div class="dropdown-menu" id="dropdown-menu1" role="menu">
				<div class="dropdown-content ">
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


@if(auth()->user()->id == $farm->owner || auth()->user()->farm_id == $farm->id)
<div id="farmContentContainer">
	<div class="tabs is-boxed has-box-content">
		<ul>
			<li class="">
				<a data-tab="info">Info</a>
			</li>
			<li class="is-active">
				<a data-tab="fields">Fields</a>
			</li>
			<li>
				<a data-tab="worklogs">Worklogs</a>
			</li>
		</ul>
	</div>

	<div class="box is-radiusless-top tab-container">
		<div class="content" id="info" data-tab="info">
			<h5 class="title is-5">Info</h5>
			<div class="columns is-multiline">

				<div class="column is-half">
						<div class="is-divider is-half-margin" data-content="Members"></div>

						<div class="card">
							<div class="card-content">

								<p class="has-text-primary has-text-weight-semibold"><span class="icon"><i class="fas fa-user-tie"></i></span><span> {{$farm->farmOwner->name}}</span></p>

								@foreach($farm->workers as $worker)
								<p class="has-text-info"><span class="icon"><i class="fas fa-tractor"></i></span><span> {{$worker->name}}</span></p>
								@endforeach
							</div>
						</div>
				</div>
				<div class="column is-half">
					<div class="is-divider is-half-margin" data-content="Season"></div>
					<div class="card">
						<div class="card-content">
							<p class="has-text-weight-semibold has-text-centered">Current Season <b>:. {{$farm->season}} .:</b></p>
							<div class="field">
								<div class="control is-expanded">
									<button id="nextSeason" class="button is-primary is-fullwidth">Next Season</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="column is-full">
					<div class="is-divider is-half-margin" data-content="Discussion"></div>
				</div>
			</div>
		</div>
		<div class="content is-active" id="fields" data-tab="fields">
			<h5 class="title is-5">Fields</h5>
			<div class="columns is-multiline">
				<div class="column is-half">
					<div class="is-divider is-half-margin" data-content="Fields"></div>
					@foreach($farm->fields as $field)
					<p>{{$field->name}}</p>
				@endforeach
				</div>
				<div class="column is-half">
					<div class="is-divider is-half-margin" data-content="Options"></div>
				</div>
			</div>
			
		</div>
		<div class="content" id="worklogs " data-tab="worklogs">
			<h5 class="title is-5">Worklogs</h5>
		</div>
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
