@php extract((array)$pageData) @endphp
@extends('layouts.userArea')

@section('scripts')
<script src="{{asset('js/farms.js')}}"></script>
@endsection

@section('content')
	<h1 class="title is-1">{{empty($worklog->name)? 'Season '.$worklog->season:$worklog->name}}</h1>
{!! empty($worklog->name)? '':'<p class="subtitle">Season '.$worklog->season.'</p>' !!}




<div class="columns">
	<div class="column is-two-thirds">
		<div class="columns">
			<div class="column">
				<h3 class="title is-3 has-text-centered">Tasks</h3>
				<div class="tabs is-centered">
					<ul>
					  <li class="is-active"><a>Required</a></li>
					  <li><a>Completed</a></li>
					</ul>
				</div>
				
				<div id="requiredTasks">
					<table class="table is-fullwidth">
						<thead>
							<tr>
							<th>Task</th><th>Field</th><th>Note</th><th>Priority</th>
							</tr>
						</thead>
						<tbody>
						@foreach($requiredTasks as $required)
							<tr>
								<td>{{$required->info->task}}</td><td>{{$required->field->name}}</td><td>{{$required->note}}</td>
								<td>
									@switch($required->priority)
										@case(0)
										Low
										@break
										@case(1)
										Medium
										@break
										@case(2)
										High
										@break
									@endswitch
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
				
				<div id="completedTasks" class="">
					@if($completedTasks->count() > 0)
					<table class="table is-fullwidth">
						<thead>
							<tr>
							<th>Task</th><th>Field</th><th>On</th><th>By</th>
							</tr>
						</thead>
						<tbody>
						@foreach($completedTasks as $completed)
							<tr>
								<td>{{$completed->info->task}}</td><td>{{$completed->field->name}}</td><td>{{$completed->completed_on}}</td><td>{{$completed->completedBy->name}}</td>
								
							</tr>
						@endforeach
						</tbody>
					</table>
					@else
					<p class="subtitle is-5 has-text-centered">No Completed Tasks</p>
					@endif
				</div>
				
				

			</div>
		</div>
	</div>
	<div class="column is-one-third">
		<button class="button is-fullwidth is-link is-large">Open Table View</button><hr/>
		<h4 class="title is-4 has-text-centered">High Priority Tasks</h4>
		@foreach ($priorityTasks as $task)
					<div class="box is-radiusless">
						<div class="columns is-multiline">
							<div class="column is-three-fifths">
								<p class="subtitle is-5">{{$task->info->task}} On Field {{$task->field->name}}</p>
							</div>
							<div class="column is-two-fifths has-text-right">
								<p class="subtitle is-6">
								@switch($task->priority)
									@case(0)
									Low
									@break
									@case(1)
									Medium
									@break
									@case(2)
									High
									@break
								@endswitch Priority
								</p>
							</div>
							<div class="column is-full">
								{!! empty($task->note)? '':'<p><span class="icon is-small has-text-grey-light"><i class="fas fa-quote-left"></i></span><span> '.$task->note.' </span><span class="icon is-small has-text-grey-light"><i class="fas fa-quote-right"></i></span></p>'!!}
							</div>
						</div>
						
						
					</div>
					@endforeach
	</div>
</div>








		

		<div class="modal">
		  <div class="modal-background"></div>
		  <div class="modal-card" id="worklogModal">
			  <header class="modal-card-head">
			  <p class="modal-card-title">All Fields & Tasks</p>
			  <a href="{{url()->previous()}}" class="delete" aria-label="close"></a>
			</header>
			  <section class="modal-card-body">
				@foreach($worklog->fields as $field)

					<div class="columns field-row">
						<div class="column field">
							<div class="columns field-head">
								<div class="column has-text-weight-bold">Field</div>
							</div>
							<div class="columns">
								<div class="column has-text-weight-bold">{{$field->info->name}}</div>
							</div>
						</div>
						@foreach($field->tasks as $task)

						<div class="column task">
							<div class="columns task-head">
								<div class="column has-text-weight-bold is-size-7">{{ $task->info->task }}</div>
							</div>
							<div class="columns">
								<div class="column">
									<div class="field is-grouped">

												<div class="control">

														<input type="checkbox"/>
												</div>

												<!-- <div class="control">
														<input type="checkbox"/>										
												</div> -->

												<div class="control">

														<input type="checkbox" />
												</div>
									</div>
								</div>
							</div>
						</div>

						@endforeach

					</div>
				@endforeach
			  </section>
		  </div>
		</div>
@endsection


