@php extract((array)$pageData) @endphp
@extends('layouts.userArea')


@section('content')


<div class="columns">
	<div class="column is-half has-text-left"><h1 class="title is-1 ">Applications</h1></div>
</div>
<div id="applications">
	
	@foreach($applications as $application)
	<div class="columns">
		<div class="column">{{$application->name}}</div>
		<div class="column">{{$application->email}}</div>
		<div class="column">{{$application->fsUk}}</div>
		<div class="column">{{\Carbon\Carbon::parse($application->birthday)->age}}</div>
		<div class="column">{{$application->country}}</div>
	</div>
	@endforeach
</div>
@endsection
