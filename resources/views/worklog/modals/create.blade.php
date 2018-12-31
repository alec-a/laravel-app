<div class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
	  <header class="modal-card-head has-background-info">
		<p class="modal-card-title has-text-light has-text-centered">New Worklog</p>
		<button class="delete" aria-label="close"></button>
	  </header>
	  <section class="modal-card-body">
		@if($warningMsg)
		<article class="notification is-warning">
			{{$warningMsg}}
		</article>
		@endif
		
		
		<form method='post' action="{{url('/farm/'.$pageData->farm->id.'/worklogs')}}">
			@csrf
			<div class="field is-horizontal ">
				<div class="field-label is normal">
					<label class="label">Name</label>
					<p class="help">Optional</p>
				</div>
				<div class="field-body">
					<div class="field">
					<div class="control is-expanded">
						<input type="text" name="name" placeholder="Leave Blank For No Name" class="input is-large">
					</div>
					</div>
				</div>
			</div>
		</form>
	  </section>
	  <footer class="modal-card-foot">
		  <div class="field is-fullwidth is-grouped is-grouped-right">
			  <div class="control is-expanded">
				  <button class="button is-primary is-fullwidth is-medium has-text-weight-bold">Create</button>
			  </div>
			  <div class="control">
				  <button class="button is-danger is-medium">Close</button>
			  </div>
		  </div>
	  </footer>
	</div>
</div>