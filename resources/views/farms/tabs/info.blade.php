<div class="content main-tab-content is-active" id="infoContent" data-tab="info">
	<h5 class="title is-5">Info</h5>
	<div class="columns is-multiline">

		<div class="column is-half">
				<div class="is-divider is-half-margin" data-content="Members"></div>

				<div class="card">
					<div class="card-content" id="members">

						<p class="has-text-primary has-text-weight-semibold is-pulled-left name" id="owner"><span class="icon"><i class="fas fa-user-tie"></i></span><span id="ownerName"> {{$farm->farmOwner->name}}</span></p>

						@foreach($farm->workers as $worker)
						<p class="has-text-info is-pulled-left name worker" ><span class="icon"><i class="fas fa-tractor"></i></span><span> {{$worker->name}}</span></p>
						@endforeach
						<div class="is-clearfix"></div>
					</div>
				</div>
		</div>
		<div class="column is-half">
			<div class="is-divider is-half-margin" data-content="Season"></div>
			<div class="card">
				<div class="card-content">
					<p class="has-text-weight-semibold has-text-centered">Current Season <b id="seasonNumber">:. {{$farm->season}} .:</b></p>
					
					@if($user->id == $farm->owner || auth()->user()->role == 1)
					<div class="field">
						<div class="control is-expanded">
							<button id="nextSeason" class="button is-primary is-fullwidth">Next Season</button>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
		<div class="column is-full">
			<div class="is-divider is-half-margin" data-content="Discussion"></div>
		</div>
	</div>
</div>