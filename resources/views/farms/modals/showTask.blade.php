<div class="modal-background is-light-dim"></div>
	<div class="modal-card has-shadow" id="farmTaskModal" data-task-id="{{$farmTask->id}}">
		<header class="modal-card-head has-background-{{$farmTask->bgColour}}"><p class="modal-card-title has-text-centered has-text-{{$farmTask->txtColour}}">{{$farmTask->title}}</p><div class="delete"></div></header>
		<section class="modal-card-body">
			
			<div class="columns" id="statusButtons">
				<div class="column is-one-quarter">
					<button class="button is-dark is-fullwidth {{($farmTask->status == 0)? 'is-hovered':'is-outlined'}}" data-status="0">Not Required</button>
				</div>
				<div class="column is-one-quarter">
					<button class="button is-info is-fullwidth {{($farmTask->status == 1)? 'is-hovered':'is-outlined'}}" data-status="1">Required</button>
				</div>
				<div class="column is-one-quarter">
					<button class="button is-warning is-fullwidth {{($farmTask->status == 2)? 'is-hovered':'is-outlined'}}" data-status="2">In Progress</button>
				</div>
				<div class="column is-one-quarter">
					<button class="button is-success is-fullwidth {{($farmTask->status == 3)? 'is-hovered':'is-outlined'}}" data-status="3">Completed</button>
				</div>
			</div>
			<div class="is-divider is-half-margin " data-content="Task"></div>
			<p class="is-size-5 has-text-weight-bold">{{$farmTask->content}}</p>
			
			@if(auth()->user()->farm_id == $farmId || auth()->user()->role == 1)
			<div class="is-divider is-half-margin " data-content="Options"></div>
			<div class="field is-grouped is-grouped-centered">
				<div class="control is-expanded">
					<button class="button is-primary is-fullwidth" id="editTask" data-task-id="{{$farmTask->id}}">Edit Task</button>
				</div>
				<div class="control is-expanded">
					<button class="button is-danger is-fullwidth" id="trashTask" data-task-id="{{$farmTask->id}}">Trash Task</button>
				</div>
			</div>
			@else
			
			
			@endif
		</section>
	</div>