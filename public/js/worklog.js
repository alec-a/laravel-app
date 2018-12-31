/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on("click", '.wltask', function(){getTask($(this));});

function getTask(task){
	console.log(task);
	var taskId = $(task).data('wlt');
	var path = '/ajax'+window.location.pathname;
	
	var formData = {
		_token:$('#token input').val(),
		task_id:taskId};
	
	
	
	console.log(taskId);
	if(taskId > 0)
	{
		$.ajax({
			type:'post',
			url:path,
			data:formData,
			success: openTask
		});
	}
	
	
	
	//$("#taskModal").css({display:'flex', opacity:0}).animate({opacity:1},250,function(){$(this).addClass('is-active')});
}

function openTask(data){
	data = JSON.parse(data);
	console.log(data.response.worklogTask);
	var wlt = data.response.worklogTask;
	//build the modal
	$("#modal").html(`
				<div class="modal" id="taskModal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">`++`</p>
      <button class="delete" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success">Save changes</button>
      <button class="button">Cancel</button>
    </footer>
  </div>
</div>
`);
	
	
}