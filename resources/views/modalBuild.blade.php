@php extract((array)$pageData) @endphp
@extends('layouts.blank')

@section('content')
<div class="modal is-active">
	<div class="modal-background is-light-dim"></div>
	<div class="modal-card has-shadow">
		<header class="modal-card-head has-background-info "><p class="modal-card-title has-text-centered has-text-white">1st Fertilizer On Field: 5</p><div class="delete"></div></header>
		<section class="modal-card-body">
			<div class="content">
				<div class="columns">
					<div class="column is-one-quarter">
						<button class="button is-dark is-outlined is-fullwidth">Not Required</button>
					</div>
					<div class="column is-one-quarter">
						<button class="button is-hovered is-info  is-fullwidth">Required</button>
					</div>
					<div class="column is-one-quarter">
						<button class="button is-warning is-outlined is-fullwidth">In Progess</button>
					</div>
					<div class="column is-one-quarter">
						<button class="button is-success is-outlined is-fullwidth">Completed</button>
					</div>
				</div>
				@include('withNote')
			</div>
		</section>
	</div>
</div>
@endsection