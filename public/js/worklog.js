/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
	populateTask();
	$('.wltask ').click(function(){
			var tm = new taskModal;
			tm.getData($(this).data('wlt'));
		});
		
	$('#tasksTabs li').click(function(){
		var tab = $(this);
		var oldTab = $("#tasksTabs .is-active");
		
		
		$(oldTab).switchClass('is-active','',300);
		$(tab).switchClass('','is-active',300);
		
		$('.activeTask').fadeOut(300,function(){
			$(this).removeClass('activeTask');
			populateTask();
		});
		
	});
	setInterval(function(){populateTask();},5000);
});

$(document).ready(function(){
	
});

function populateTask(){
	
	var taskId = $('#tasksTabs .is-active').data('task');
	var formData = {
		_token:$("#token input").val(),
		task:taskId
	};
	var ajax_url = '/ajax'+window.location.pathname;
	$.ajax({
		type:'post',
		data:formData,
		url:ajax_url,
		success:function(data){
			data=JSON.parse(data);
			if($('.task[data-task="'+taskId+'"] #wlTasks').length > 0)
			{
				$('.task[data-task="'+taskId+'"] #wlTasks').html('');
			}
			else{
				$('.task[data-task="'+taskId+'"]').append('<div class="columns is-multiline is-marginless" id="wlTasks"></div>');
			}
					
			for(var i=0; i < data.response.worklogTasks.length; i++){
				var task = data.response.worklogTasks[i];
				var appendHtml =	`<div class="column is-one-tenth has-background-${task.bgColour} has-text-${task.txtColour} wltask " data-wlt="${task.id}">
										<div class="columns">
											<div class="column">
												${task.field.info.name}
											</div>
										</div>
										<div class="columns">
											<div class="column">
												${task.field.crop.name}
											</div>
										</div>
									</div>`;
				$('.task[data-task="'+taskId+'"] #wlTasks').append(appendHtml);
			}
			
			if(!$('.task[data-task="'+taskId+'"]').hasClass('activeTask'))
			{
				$('.task[data-task="'+taskId+'"]').fadeIn(300,function(){
					$(this).addClass('activeTask');
				});
			}
			
		}
	});
	
}

$(document).on("click",'.wltask ',function(){
			var tm = new taskModal;
			tm.getData($(this).data('wlt'));
		});