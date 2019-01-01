@php extract((array)$pageData) @endphp
@extends('layouts.blank')

@section('content')
<div class="modal is-active is-transparent">
	<div class="modal-background is-light-dim"></div>
	<div class="modal-card has-shadow">
		<header class="modal-card-head has-background-warning "><p class="modal-card-title has-text-centered has-text-dark">1st Fertilizer On Field: 5</p><div class="delete"></div></header>
		<section class="modal-card-body">
			<div class="content">
				<div class="columns">
					<div class="column is-one-quarter">
						<a class="button is-dark is-outlined is-fullwidth">Not Required</a>
					</div>
					<div class="column is-one-quarter">
						<a class="button is-outlined is-info  is-fullwidth">Required</a>
					</div>
					<div class="column is-one-quarter">
						<a class="button is-warning is-hovered is-fullwidth">In Progess</a>
					</div>
					<div class="column is-one-quarter">
						<a class="button is-success is-outlined is-fullwidth">Completed</a>
					</div>
				</div>
				<div id="taskModalContent"></div>
			</div>
		</section>
	</div>
</div>
@endsection