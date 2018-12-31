@php extract((array)$pageData) @endphp
@extends('layouts.blank')

@section('content')
<div class="modal is-active">
	<div class="modal-card">
		<header class="modal-card-head"><p class="modal-card-title has-text-centered">1st Fertilizer On Field: 5</p><div class="delete"></div></header>
		<section class="modal-card-body">
			<div class="content">
				<div class="field is-fullwidth is-grouped">
					<div class="control">
						<button class="button is-dark is-outlined">Not Required</button>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
@endsection