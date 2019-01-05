/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
	populateTask();
	tabColours();
	$('.wltask ').click(function(){
			var tm = new taskModal;
			tm.getData($(this).data('wlt'));
		});
		
	$('#tasksTabs li').click(function(){
		var tab = $(this);
		var oldTab = $("#tasksTabs .is-active");
		
		
		$(oldTab).switchClass('is-active','',300);
		$(tab).switchClass('','is-active',300);
		
		$('.activeTask').slideUp(200,function(){
			$(this).removeClass('activeTask');
			populateTask();
		}).fadeOut(200);
		
	});
	setInterval(function(){populateTask();},5000);
});

function populateTask(){
	tabColours();
	var taskId = $('#tasksTabs .is-active').data('task');
	var sortByType = $('#sortBy').data('sortBy');;
	var sortDirection = $('#sortDir').data('sortDir');
	var formData = {
		_token:$("#token input").val(),
		task:taskId,
		sortBy:sortByType,
		sortDir:sortDirection
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
				var note = (task.note != null)? true:false;
				var appendHtml =	`<div class="column is-one-tenth has-background-${task.bgColour} has-text-${task.txtColour} wltask " data-wlt="${task.id}">
										<div class="columns">
											<div class="column">
												<span>${task.field.info.name}</span>
												<span id="noteIcon" class="icon is-pulled-right ${note? '':'is-invisible'}"><i class="fas fa-sticky-note"></i></span>
											</div>
										</div>
										<div class="columns">
											<div class="column cropType">
												${displayCrop(task)}
												
											</div>
										</div>
									</div>`;
				$('.task[data-task="'+taskId+'"] #wlTasks').append(appendHtml);
			}
			
			if(!$('.task[data-task="'+taskId+'"]').hasClass('activeTask'))
			{
				$('.task[data-task="'+taskId+'"]').slideDown(200,function(){
					$(this).addClass('activeTask');
				}).fadeIn(200);
			}
			
		}
	});
	
}

function displayCrop(task){
	if(task.task_id == 6 || task.field.is_planted){
		return task.field.crop.name;
	}
	else{
		return '';
	}
}

function tabColours(){
	var formData = {
		_token:$("#token input").val(),
		tabColours:true
	};
	var ajax_url = '/ajax'+window.location.pathname;
	$.ajax({
		type:'post',
		data:formData,
		url:ajax_url,
		success:function(data){
			data = JSON.parse(data);
			var tabClasses = data.response.tabClasses;
			var tabIcons = data.response.tabIcons;
			tabClasses = Object.entries(tabClasses);
			tabIcons = Object.entries(tabIcons);
			new Map(tabClasses).forEach(changeTabColour);
			new Map(tabIcons).forEach(changeTabIcon);
		}
	});
	
}

function changeTabColour(tabClass,taskId,map){
	
	$('#tasksTabs li[data-task="'+taskId+'"] a').attr('class',tabClass);
}
function changeTabIcon(tabIcon,taskId,map){
	$('#tasksTabs li[data-task="'+taskId+'"]').find('.icon').remove();
	$('#tasksTabs li[data-task="'+taskId+'"] a').prepend(tabIcon);
}

$(document).on("click",'.wltask ',function(){
	var tm = new taskModal;
	tm.getData($(this).data('wlt'));
});

$(document).on("click",'#sortDir', function(e){
	e.preventDefault();
	
	var oldDir = $(this).data('sortDir');
	
	
	if(oldDir == 0){
		
		$(this).children().find('i').first().switchClass('fa-angle-up','fa-angle-down');
		$(this).data('sortDir',1);
		populateTask();
	}
	else{
		$(this).data('sortDir','0');
		$(this).children().find('i').first().switchClass('fa-angle-down','fa-angle-up',{complete:function(){
				populateTask();
		}});
	}
});

$(document).on("click",'#changeSortBy',function(e){
	e.preventDefault();
	var newSortBy = {value:$(this).data('sortBy'),
					 text:$(this).text()
	};
	
	var oldSortBy = {
		value:$("#sortBy").data('sortBy'),
		text:$("#sortBy").text()
	};
	
	$(this).data('sortBy',oldSortBy.value);
	$("#sortBy").data('sortBy',newSortBy.value);
	$(this).text(oldSortBy.text);
	$("#sortBy").text(newSortBy.text);
	
	populateTask();
});
