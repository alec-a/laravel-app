<script src="{{asset('js/modals.js')}}"></script>
<div class="modal" id="fieldModal">
	<form method="post" action="{{url('/farms/'.$pageData->farm->id)}}">
	@csrf
	@method('DELETE')
	</form>
  <div class="modal-background"></div>
  <div class="modal-card ">
    <header class="modal-card-head has-background-info">
      <p class="modal-card-title has-text-white">Add Field(s)</p>
      
    </header>
    <section class="modal-card-body">
		<p class="title is-4"><strong>Add Field Numbers / Names To Your Farm</strong></p>
		<div id="fields">
			<div class="field">
				<div class="control">
					<input type="text" class="input" name="field[1]"/>
				</div>
			</div>
		</div>
		<div class="field">
			<div class="control">
				<input type="text" class="input" name="field[1]"/>
			</div>
		</div>
		<div class="field is-grouped">
			<div class="control">
				<button class="button is-danger is-large" id="deleteYes">Yes</button>
			</div>
			<div class="control">
				<button class="button is-info is-large" id="deleteNo">No</button>
			</div>
		</div>
		
      
    </section>
  </div>
</div>