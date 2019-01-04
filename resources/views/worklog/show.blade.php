@php extract((array)$pageData) @endphp

@extends('layouts.worklog')
@section('scripts')
<script src="{{asset('js/taskModal.js')}}"></script>
<script src="{{asset('js/worklog.js')}}"></script>

@endsection
@section('content')
<div class="columns">
	<div class="column">
		<h1 class="title is-1">{{empty($worklog->name)? 'Season '.$worklog->season : $worklog->name}}</h1>
		{!! empty($worklog->name)? '':'<p class="subtitle">Season '.$worklog->season.'</p>' !!}
	</div>
	<div class="column">
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Sort By:</label>
			</div>
			<div class="field-body">
				<div class="field is-narrow">
					<div class="control">
						<div class="dropdown" >
							<div class="dropdown-trigger">
								<button class="button" aria-haspopup="true" aria-controls="otherType">
									<span id="sortBy" data-sort-by="0">Field Name</span>
									<span class="icon is-small">
										<i class="fas fa-angle-down" aria-hidden="true"></i>
									</span>
								</button>
							</div>
							<div class="dropdown-menu" id="otherType" role="menu">
								<div class="dropdown-content">
									<a class="dropdown-item" id="changeSortBy" data-sort-by="1">Crop Type</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="field">
					<button class="button" id="sortDir" data-sort-dir="0">
						<span class="icon is-small">
							<i class="fas fa-angle-up" aria-hidden="true"></i>
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="tabs is-boxed is-small is-centered has-box-content">
	<ul id="tasksTabs">
		@foreach($tasks as $task)	
		<li class="{{$loop->iteration == 1? 'is-active':''}}" data-task="{{$task->id}}"><a data-task="{{$task->id}}">{{$task->task}}</a></li>
		@endforeach
	</ul>
</div>
<div class="box">
@foreach($tasks as $task)
	
	<div data-task="{{$task->id}}" class="content {{$loop->iteration > 1? '':'activeTask'}} task">
		<h5 class="title is-5">{{$task->task}}</h5>
	</div>
	
	@endforeach
</div>
@endsection