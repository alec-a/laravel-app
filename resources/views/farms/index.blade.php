@extends('layouts.userArea')

@section('scripts')
<script src="{{asset('js/farms.js')}}"></script>
@endsection

@section('content')
<div class="modal" id="newModal">
	
  <div class="modal-background"></div>
  <div class="modal-card ">
    <header class="modal-card-head">
      <p class="modal-card-title">New Farm</p>
      
    </header>
    <section class="modal-card-body">
		<form id="newFarmForm" method="post">
		<div class="field">
			@csrf
			<label class="label is-large" for="farmName">Name Your Farm</label>
			<div class='control'>
				<input type="text" name="farmName" class="input is-large" placeholder="Farm Name"/>
			</div>
		</div>
		<div class="field is-grouped">
			<div class="control">
				<button class="button is-success is-large" id="newCreate">Create</button>
			</div>
			<div class="control">
				<button class="button is-info is-large" id="newClose">Close</button>
			</div>
		</div>
		</form>
      
    </section>
  </div>
</div>

<div class="columns">
	<div class="column is-half has-text-left"><h1 class="title is-1 ">Farms</h1></div>
	<div class="column is-half has-text-right"><button class="button is-success" id="new">New Farm</button></div>

</div>
<div id="farms">
@foreach($pageData->farms as $farm)
	@if($loop->first)
	<div class="columns is-multiline">
	@endif
	
	
	@if(is_object($farm->farmOwner))
	<a class="column is-one-third" href="{{url('farm/'.$farm->id)}}">
		<div class="box is-fullheight has-text-centered">
			<img src="{{asset('/img/barn.png')}}"></img>
			<hr/>
			<h3 class="title is-4 ">{{$farm->name}}</h3>
			
			<hr/>
			<p class="subtitle ">{{$farm->farmOwner->name}}</p>
			
		</div>
	</a>
	@endif
	
	@if($loop->last)
		
	</div>
	@endif
@endforeach
</div>
@endsection
