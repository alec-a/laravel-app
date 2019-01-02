@php extract((array)$pageData) @endphp

@extends('layouts.worklog')
@section('scripts')
<script src="{{asset('js/taskModal.js')}}"></script>
<script src="{{asset('js/worklog.js')}}"></script>

@endsection
@section('content')

<h1 class="title is-1">{{empty($worklog->name)? 'Season '.$worklog->season : $worklog->name}}</h1>
{!! empty($worklog->name)? '':'<p class="subtitle">Season '.$worklog->season.'</p>' !!}
<div class="tabs is-boxed is-small is-centered">
	<ul id="tasksTabs">
		@foreach($tasks as $task)	
		<li class="{{$loop->iteration == 1? 'is-active':''}}" data-task="{{$task->id}}"><a data-task="{{$task->id}}">{{$task->task}}</a></li>
		@endforeach
	</ul>
</div>
@foreach($tasks as $task)
	<div data-task="{{$task->id}}" class="content {{$loop->iteration > 1? '':'activeTask'}} task">
		<h5 class="title is-5">{{$task->task}}</h5>
		@if($loop->iteration == 1)
		
			<div class="columns is-multiline is-marginless" id="wlTasks">
			@foreach($worklog->tasks->where('task_id','=',$task->id) as $wlt)
			<div class="column is-one-tenth has-background-{{$wlt->getColour()->bgColour}} has-text-{{$wlt->getColour()->txtColour}} wltask {{$loop->iteration%10 == 0? 'is-last-in-row':''}}" data-wlt="{{$wlt->id}}">
				<div class="columns">
					<div class="column">
						{{$wlt->field->info->name}}
					</div>
				</div>
				<div class="columns">
					<div class="column">
						{{!empty($wlt->field->crop)? $wlt->field->crop->name:''}}
					</div>
				</div>
			</div>
			@endforeach
			</div>
		@endif
		
	</div>
	@endforeach
@endsection