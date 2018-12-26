
<div class="modal is-active" id="deleteModal">
	<form method="post" action="{{url('/farms/'.$farmId)}}">
	@csrf
	@method('DELETE')
	</form>
  <div class="modal-background"></div>
  <div class="modal-card ">
    <header class="modal-card-head has-background-danger">
      <p class="modal-card-title has-text-white">Delete Farm</p>
      
    </header>
    <section class="modal-card-body">
		<p class="title is-4"><strong>Are You Sure You Want To Delete Your Farm?</strong></p>
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

<script>
	$("#deleteYes").focus();
			$("#deleteNo").click(function(){
				$('#deleteModal').removeClass('is-active');
			});
			
			$("#deleteYes").click(function(){
				$('#deleteModal').removeClass('is-active');
				$('#deleteModal form').submit();
			});
	
</script>