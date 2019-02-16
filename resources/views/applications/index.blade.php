@php extract((array)$pageData) @endphp
@extends('layouts.userArea')

@section('scripts')
<script src="{{asset('js/applications.js')}}"></script>
@endsection


@section('content')


<div class="columns">
	<div class="column is-half has-text-left"><h1 class="title is-1 ">Applications</h1></div>
</div>
<div id="applicationsContentContainer">
	<div class="tabs is-boxed has-box-content" id="applicationsTabs">
		<ul>
			<li class="is-active">
				<a href="#new" data-tab="new" data-status-group="0">New</a>
			</li>
			<li class="">
				<a href="#trial" data-tab="trial" data-status-group="1">On Trial</a>
			</li>
			<li>
				<a href="#declined" data-tab="declined" data-status-group="2">Declined</a>
			</li>
		</ul>
	</div>
	<div class="box is-radiusless-top tab-container">


		<div class="content main-tab-content is-active" id="newApplications" data-tab="new">
			<h4 class="title is-4">New Applications</h4>
			<table class="table">
				<thead>
				   <tr>
					   <th>Name</th>
					   <th>Email</th>
					   <th>Fs-Uk Username</th>
					   <th>Age</th>
					   <th>Country</th>
				   </tr>
				</thead>
				<tbody>
					@foreach($applications as $application)
						@if($application->application_status == 0)
							<tr class="applicant" data-application-id="{{$application->id}}">
								<td>{{$application->name}}</td>
								<td>{{$application->email}}</td>
								<td>{{$application->fsUk}}</td>
								<td>{{\Carbon\Carbon::parse($application->birthday)->age}}</td>
								<td>{{$data->countries[$application->country]}}</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="content main-tab-content" id="trialApplications" data-tab="trial">
			<h4 class="title is-4">Applicants On Trial</h4>
			<table class="table">
				<thead>
				   <tr>
					   <th>Name</th>
					   <th>Email</th>
					   <th>Fs-Uk Username</th>
					   <th>Age</th>
					   <th>Country</th>
				   </tr>
				</thead>
				<tbody>
					@foreach($applications as $application)
						@if($application->application_status == 1)
							<tr class="applicant" data-application-id="{{$application->id}}">
								<td>{{$application->name}}</td>
								<td>{{$application->email}}</td>
								<td>{{$application->fsUk}}</td>
								<td>{{\Carbon\Carbon::parse($application->birthday)->age}}</td>
								<td>{{$data->countries[$application->country]}}</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="content main-tab-content" id="declinedApplications" data-tab="declined">
			<div class="columns">
				<div class="column is-three-quarters"><h4 class="title is-4">Declined Applications</h4></div>
				<div class="column is-one-quarter" style="display:none;" id="actions"><div  class="is-pulled-right">with Selected: <div class="buttons"><button class="button is-danger is-small" id="delete">Delete</button></div></div></div>
			</div>
			
			
			<table class="table">
				<thead>
				   <tr>
					   <th><input type="checkbox" class="checkbox" id="selectAll"/></th>
					   <th>Name</th>
					   <th>Email</th>
					   <th>Fs-Uk Username</th>
					   <th>Age</th>
					   <th>Country</th>
				   </tr>
				</thead>
				<tbody>
					@foreach($applications as $application)
						@if($application->application_status == 2)
							<tr class="applicant" data-application-id="{{$application->id}}">
								<td class="selector"><input type="checkbox" class="checkbox" /></td>

								<td>{{$application->name}}</td>
								<td>{{$application->email}}</td>
								<td>{{$application->fsUk}}</td>
								<td>{{\Carbon\Carbon::parse($application->birthday)->age}}</td>
								<td>{{$data->countries[$application->country]}}</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
