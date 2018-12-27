@extends('layouts.userArea')

@section('scripts')
<script src="{{asset('js/farms.js')}}"></script>
@endsection

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
					<a class="dropdown-item is-bold has-text-centered has-text-light is-static" id="addFields">
						<strong>Add Fields</strong>
					</a>
					<a class="dropdown-item is-bold has-text-centered has-text-light is-static" id="season">
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
	<div class="column is-two-thirds">
		<div class="box has-text-weight-bold">
			<h3 class="title is-3 has-text-centered">Fields</h3>
			<div id="fields">
				<form id="editFieldForm" method="post" class="hidden">
						@csrf
						@method('PUT')
						<div class="field has-addons">
							<div class="control is-expanded">
								<input id="fieldName" type="text" name="name" class="input" placeholder="Name Or Number"/>
							</div>
							<div class="control">
								<div class="select">
									<select id="fieldCrop" name="crop_id">
										<option disabled selected>Crop</option>
										@foreach(Lakeview\Crops::all() as $crop)
										<option value="{{$crop->id}}">{{$crop->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="control">
								<button class="button is-primary" type="submit" id="saveField"><span class="icon is-small"><i class="fas fa-check"></i></span><span class="hidden">save</span></button>
							</div>
							<div class="control">
								<button class="button is-warning" type="button" id="cancelEditField"><span class="icon is-small"><i class="fas fa-times"></i></span><span class="hidden">Cancel</span></button>
							</div>
						</div>
					</form>
				@if($pageData->farm->fields->count() > 0)
				
					@foreach($pageData->farm->fields as $field)
					<div class="columns farmField" id="field_{{$field->id}}">
						<div class="column is-one-fifth options">
							<div class="hidden">
								 <div class="field is-grouped">
									<div class="control">
										<button name="fieldId" value="{{$field->id}}" class="button is-danger deleteField"><span class="icon is-small"><i class="fas fa-trash-alt"></i></span></button>
									</div>
									<div class="control">
										<button name="fieldId" value="{{$field->id}}" class="button is-link editField"><span class="icon is-small"><i class="fas fa-pencil-alt"></i></span></button>
									</div>
								 </div>
							</div>
						</div>
						<div class="column is-two-fifths fieldName">{{$field->name}}</div>
						<div class="column is-two-fifths fieldCrop">{{$field->crop->name}}</div>
						
					</div>
					@endforeach
			</div>
				@else
			</div>
			<article class="notification is-primary" id="fieldsNotification">Please Add Fields To The Farm</article>
			@endif
			<div class="columns">
				<div class="column">
					<form id="newFieldForm" method="post">
						@csrf
						<div class="field has-addons">
							<div class="control is-expanded">
								<input type="text" name="name" class="input" placeholder="Name Or Number"/>
							</div>
							<div class="control">
								<div class="select">
									<select name="crop_id">
										<option disabled selected>Crop</option>
										@foreach(Lakeview\Crops::all() as $crop)
										<option value="{{$crop->id}}">{{$crop->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="control">
								<button class="button is-primary" type="submit" id="newField"><span class="icon is-small"><i class="fas fa-plus"></i></span><span>Add</span></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="box has-text-weight-bold">
			<h3 class="title is-3 has-text-centered">Worklogs</h3>
			<article class="notification is-warning">
				<p>Worklogs Can Only Be Created When The Farm Has Fields</p>
			</article>
		</div>
		<div class="box has-text-weight-bold">
			<h3 class="title is-3 has-text-centered">Discussion</h3>
		</div>
	</div>
		
	<div class="column is-one-third">
		<div class="box has-text-weight-bold is-radiusless is-shadowless is-paddingless">
			<h3 class="title is-3 has-text-centered">Info</h3>
			<p>Season: {{$pageData->farm->season}}</p>
			<p>Owner: {{$pageData->farm->farmOwner->name}}</p>
		</div>
		<hr/>
		<div class="box has-text-weight-bold  is-radiusless is-shadowless is-paddingless">
			<h3 class="title is-3 has-text-centered">Members</h3>
			@if ($pageData->farm->workers->count() > 0 )
			<p class="subtitle">{{$pageData->farm->workers->count()}}</p>
				@foreach($pageData->farm->workers as $worker)
					<li>{{$worker->name}}</li>						
				@endforeach
			</ul>
			@else
			<article class="notification is-info">The Farm Has No Staff, Get Recruiting!</article>
			@endif
		</div>
		<hr/>
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
