<div class="content main-tab-content" id="tasksContent" data-tab="tasks">
	<h5 class="title is-5 is-pulled-left">Tasks</h5>
	@if($user->id == $farm->owner || auth()->user()->role == 1)
		<div class="tabs is-pulled-right is-toggle" id="tasksTabs">
			<ul class="is-marginless">
				<li class="is-marginless {{($farm->fields->count() > 0)? '':'is-disabled'}}">
					<a class="is-success-tab " data-action="newTask">New Task</a>
				</li>
				<li class=" is-marginless is-active">
					<a data-tab="normalTasks">Tasks</a>
				</li>
				<li class="is-marginless">
					<a class="is-danger-tab" data-tab="trashedTasks">Trashed</a>
				</li>
			</ul>
		</div>
	@endif
	<div class="is-clearfix"></div>

	<div id="normTasks" class="is-active tab-content" data-tab="normalTasks">
		<h3 class="title has-text-centered {{($farm->tasks->count() > 0)?'is-hidden':'showing'}}" id="noTasks">No Tasks</h3>
		
		<div class="columns is-multiline is-marginless">
			@foreach($farm->tasks()->orderBy('id', 'DESC')->get() as $farmTask)
			@php $farmTask->getColour(); @endphp
			<div class="column is-one-third">
				<div class="card farmTask" data-task-id="{{$farmTask->id}}">
					<header class="card-header has-background-{{$farmTask->bgColour}} has-text-centered">
						<p class="card-header-title has-text-{{$farmTask->txtColour}} is-unselectable has-text-centered">{{$farmTask->title}}</p>
					</header>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	
	@if($user->id == $farm->owner || auth()->user()->role == 1)
	<div id="trashedTasks" class="tab-content" data-tab="trashedTasks">
		@if($farm->tasks()->onlyTrashed()->get()->count() > 0)
		<div class="columns is-multiline is-marginless">
			@foreach($farm->tasks()->onlyTrashed()->orderBy('updated_at', 'DESC')->get() as $farmTask)
			@php $farmTask->getColour(); @endphp
			<div class="column is-one-third">
				<div class="card farmTaskTrashed" data-task-id="{{$farmTask->id}}">
					<header class="card-header has-background-{{$farmTask->bgColour}} has-text-centered">
						<p class="card-header-title has-text-{{$farmTask->txtColour}} is-unselectable has-text-centered">{{$farmTask->title}}</p>
					</header>
					<footer class="card-footer">
						<a class="card-footer-item taskRecoverButton" data-task-id="{{$farmTask->id}}">Restore</a>
						<a class="card-footer-item has-text-danger taskDeleteButton" data-task-id="{{$farmTask->id}}">Delete</a>
					</footer>
				</div>
			</div>
			@endforeach
		@endif
		</div>
	</div>
	@endif
