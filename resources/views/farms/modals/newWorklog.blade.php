<div class="modal-background is-light-dim"></div>
	<div class="modal-card has-shadow" id="worklogModal">
		<header class="modal-card-head"><p class="modal-card-title has-text-centered has-text-dark">Name For Worklog</p><div class="delete"></div></header>
		<section class="modal-card-body">
			<p class="subtitle is-size-6 has-text-weight-semibold has-text-centered">Leave Blank For The Worklog To Be Named <b>"Season {{$farm->season}}"</b></p>
			
			@if(!empty($farm->currentWorklog) && empty($editWorklog))
			<p class="subtitle has-text-danger has-text-weight-bold is-size-6 has-text-centered">Warning, Creating A New Worklog Will Overwrite "{{(!empty($farm->currentWorklog->name))?$farm->currentWorklog->name:'Season '.$farm->currentWorklog->season}}"</p>
			@endif
			<div class="field has-addons">
				<div class="control is-expanded">
					<input type="text" id="worklogName" class="input" @if(!empty($editWorklog)) value="{{$editWorklog->name}}"  @endif/>
				</div>
				<div class="control">
					<button id="worklogNameButton" type="submit" class="button is-primary">{{(empty($editWorklog)? 'New':'Edit')}} Worklog</button>
				</div>
			</div>
		</section>
	</div>