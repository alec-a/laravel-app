@php extract((array)$pageData) @endphp
@extends('layouts.blank')

@section('content')
<div class="modal is-active">
	<div class="modal-background is-transparent"></div>
	<div class="modal-card has-shadow">
		<header class="modal-card-head"><p class="modal-card-title has-text-centered has-text-dark">Name For Worklog</p><div class="delete"></div></header>
		<section class="modal-card-body">
			<p class="subtitle is-size-6 has-text-weight-semibold has-text-centered">Leave Blank For The Worklog To Be Named <b>"Season ${farm.season}"</b></p>
			<div class="field has-addons">
				<div class="control is-expanded">
					<input type="text" id="worklogName" class="input"/>
				</div>
				<div class="control">
					<button id="worklogNameButton" type="submit" class="button is-primary">New Worklog</button>
				</div>
			</div>
		</section>
	</div>
</div>
@endsection