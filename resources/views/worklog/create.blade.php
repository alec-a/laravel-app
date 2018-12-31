@extends('layouts.userArea')



@section('scripts')
<script src="{{asset('js/farms.js')}}"></script>
@endsection

@section('content')
<h1 class="title is-1">Worklogs</h1>
<p class="subtitle">New Worklog</p>
	
<form method='post' action="{{url('/farm/'.$pageData->farm->id.'/worklogs')}}">
	@csrf
	<div class="field is-horizontal ">
		<div class="field-label is normal">
			<label class="label">Name</label>
			<p class="help">Optional</p>
		</div>
		<div class="field-body">
			<div class="field">
			<div class="control is-expanded">
				<input type="text" name="name" class="input is-large">
			</div>
			</div>
		</div>
	</div>
	<div class="field is-grouped is-grouped-centered">
		<div class="control">
			<button type="submit" class="button is-primary has-text-weight-bold is-large">Create</button>
		</div>
		<div class="control">
			<a href="{{url()->previous()}}" class="button is-link has-text-weight-bold is-large">Back</a>
		</div>
	</div>
</form>
@endsection
