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
		
		
	</div>
	@endforeach
@endsection