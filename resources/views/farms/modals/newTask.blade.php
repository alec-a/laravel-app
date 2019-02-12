<div class="modal-background is-light-dim"></div>
	<div class="modal-card has-shadow" id="newFarmTaskModal">
		<header class="modal-card-head"><p class="modal-card-title has-text-centered has-text-dark">New Task</p><div class="delete"></div></header>
		<section class="modal-card-body">
			<div class="columns" id="statusButtons">
				<div class="column is-one-quarter">
					<button class="button is-dark is-fullwidth is-hovered" data-status="0">Not Required</button>
				</div>
				<div class="column is-one-quarter">
					<button class="button is-info is-fullwidth is-outlined" data-status="1">Required</button>
				</div>
				<div class="column is-one-quarter">
					<button class="button is-warning is-fullwidth is-outlined" data-status="2">In Progress</button>
				</div>
				<div class="column is-one-quarter">
					<button class="button is-success is-fullwidth is-outlined" data-status="3">Completed</button>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label">
					<label class="label" for="title">Title</label>
				</div>
				<div class="field-body">
					<div class="field">
						<div class="control is-expanded">
							<input type="text" id="taskTitle" class="input"/>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label">
					<label class="label" for="title">Description</label>
				</div>
				<div class="field-body">
					<div class="field">
						<div class="control is-expanded">
							<textarea class="textarea" id="taskDescription"></textarea>
						</div>
					</div>
				</div>
			</div>
			
			<div class="field is-grouped is-grouped-centered">
				<div class="control">
					<button class="button is-primary" id="addTask">Add Task</button>
				</div>
				<div class="control">
					<button class="button is-light close">Cancel</button>
				</div>
			</div>
		</section>
	</div>