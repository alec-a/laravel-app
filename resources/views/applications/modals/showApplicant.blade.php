<div class="modal-background is-light-dim"></div>
	<div class="modal-card has-shadow" id="applicantModal" data-id="{{$applicant->id}}">
		<header class="modal-card-head has-background-{{$applicant->bgColour()}}"><p class="modal-card-title has-text-centered has-text-{{$applicant->txtColour()}}">{{$applicant->name}}'s Application</p><div class="delete"></div></header>
		<section class="modal-card-body">
			<div class="columns" id="statusButtons">
				<div class="column is-one-quarter">
					<button class="button is-dark is-fullwidth {{($applicant->application_status == 0)? 'is-hovered':'is-outlined'}}" data-status="0">Applied</button>
				</div>
				<div class="column is-one-quarter">
					<button class="button is-warning is-fullwidth {{($applicant->application_status == 1)? 'is-hovered':'is-outlined'}}" data-status="1">On Trial</button>
				</div>
				<div class="column is-one-quarter">
					<button class="button is-success is-fullwidth {{($applicant->application_status == 3)? 'is-hovered':'is-outlined'}}" data-status="3">Accepted</button>
				</div>
				<div class="column is-one-quarter">
					<button class="button is-danger is-fullwidth {{($applicant->application_status == 2)? 'is-hovered':'is-outlined'}}" data-status="2">Declined</button>
				</div>
			</div>
			<div class="columns is-multiline is-vcentered has-text-centered">
				<div class="column is-half">
					<p class="title is-5">Applied On</p>
					<p class="subtitle is-6">{{\Carbon\Carbon::parse($applicant->created_at)->toFormattedDateString()}}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Email</p>
					<p class="subtitle is-6">{{$applicant->email}}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Fs Uk Username</p>
					<p class="subtitle is-6">{{$applicant->fsUk}}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Age</p>
					<p class="subtitle is-6">{{\Carbon\Carbon::parse($applicant->birthday)->age}}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Country</p>
					<p class="subtitle is-6">{{$pageData->data->countries[$applicant->country]}}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Timezone</p>
					<p class="subtitle is-6">{{$pageData->data->timezones[$applicant->timezone]}}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Speaks English?</p>
					<p class="subtitle is-6">{!!($applicant->english == 1)? '<span class="has-text-success">Yes</span>':'<span class="has-text-danger">No</span>'!!}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Has Discord?</p>
					<p class="subtitle is-6">{!!($applicant->discord == 1)? '<span class="has-text-success">Yes</span>':'<span class="has-text-danger">No</span>'!!}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Has Mic?</p>
					<p class="subtitle is-6">{!!($applicant->mic == 1)? '<span class="has-text-success">Yes</span>':'<span class="has-text-danger">No</span>'!!}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Part Of Another Server?</p>
					<p class="subtitle is-6">{!!($applicant->otherServer == 1)? '<span class="has-text-danger">Yes</span>':'<span class="has-text-success">No</span>'!!}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Has Experience?</p>
					<p class="subtitle is-6">{!!($applicant->experience == 1)? '<span class="has-text-success">Yes</span>':'<span class="has-text-danger">No</span>'!!}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Willing To Donate?</p>
					<p class="subtitle is-6">{!!($applicant->donate == 1)? '<span class="has-text-success">Yes</span>':'<span class="has-text-danger">No</span>'!!}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">About Them</p>
					<p class="subtitle is-6">{{$applicant->about}}</p>
				</div>
				<div class="column is-half">
					<p class="title is-5">Why They Want To Be Part Of The Team</p>
					<p class="subtitle is-6">{{$applicant->whyPartOfTeam}}</p>
				</div>
			</div>
		</section>
	</div>