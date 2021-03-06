var tabs = ['info','fields','worklogs','tasks','stock'];

function optionEvents(){
	
	
	$(document).on("click", '#saveFarmName', function(evt){ updateFarmName(evt); });
	$(document).on("click", "#normFields .farmField", function(e){ e.preventDefault(); fieldClick($(this)); });
	$(document).on("click", "#deletedFields .farmField", function(e){ e.preventDefault(); fieldClickTrashed($(this)); });
	$(document).on( "keydown", "#fieldName",function(event){ if(event.which == 13) { fieldNewOrRename(); } });
	$(document).on( "click", "#fieldNameButton",function(e){ e.preventDefault(); fieldNewOrRename(); });
	$(document).on( "click", "#moveToTrashButton",function(e){ e.preventDefault(); fieldsTrash(); });
	$(document).on( "click", "#emptyTrashButton, #deleteButton",function(e){ e.preventDefault(); emptyTrash($(this)); });
	$(document).on( "click", "#recoverButton",function(e){ e.preventDefault(); fieldsRecover($(this)); });
	$(document).on( "click", ".worklogRenameButton",function(e){ e.preventDefault(); worklogRename($(this)); });
	$(document).on( "click", ".worklogTrashButton",function(e){ e.preventDefault(); worklogTrash($(this)); });
	$(document).on( "click", ".worklogRecoverButton",function(e){ e.preventDefault(); worklogRecover($(this)); });
	$(document).on( "click", ".worklogDeleteButton",function(e){ e.preventDefault(); worklogDelete($(this)); });
	$(document).on( "click", "#nextSeason",function(e){ e.preventDefault(); nextSeason(); });
	$(document).on("click",".farmTask", function(e){ e.preventDefault(); e.stopImmediatePropagation(); taskView($(this));});
	$(document).on("click",".taskDeleteButton", function(e){ e.preventDefault(); e.stopImmediatePropagation(); taskDelete($(this));});
	$(document).on("click",".taskRecoverButton", function(e){ e.preventDefault(); e.stopImmediatePropagation(); taskRecover($(this));});
	$(document).on('click','#farmTaskModal #statusButtons .button',function(e){
						e.preventDefault();
						e.stopImmediatePropagation();
						changeTaskStatus($(this));
					});

					$(document).on( "click", "#modal #editTask",function(event){ 
						event.stopImmediatePropagation();
						event.preventDefault();
						taskEdit($(this));
					});
					
					$(document).on('click','#modal #trashTask', function(event){
						event.stopImmediatePropagation();
						event.preventDefault();
						taskTrash($(this));
					});
	
}

$(document).ready(function(){
	optionEvents();
	//farm
	$("#new").click(function(evt){ newFarm(evt); });
	$("#deleteFarm").click(function(){ deleteFarm(); });
	$("#rename").click(function(){ renameFarm(); });
	$('#cancelRename').click(function(){ cancelRename(); });	
	
	//field
	$('#newFieldForm').submit(function(evt){ newField(evt);	});


	//tabs
	if(window.location.hash){
		var target = window.location.hash.substring(1);
		if(tabs.indexOf(target) > -1 && !$('#farmContentContainer .content[data-tab="'+target+'"]').hasClass('is-active')){
			$('#farmContentContainer #farmTabs li.is-active').switchClass('is-active','',1);
			$('#farmContentContainer #farmTabs li a[data-tab="'+target+'"]').parent().addClass('is-active');
			$('#farmContentContainer .main-tab-content.is-active').switchClass('is-active','').hide();
			$('#farmContentContainer .main-tab-content[data-tab="'+target+'"]').switchClass('', 'is-active',1).show();
		}
	}
	
	$('#farmContentContainer #farmTabs li a').click(function(){
		var target = $(this).data('tab');
		if(!$('#farmContentContainer .main-tab-content[data-tab="'+target+'"]').hasClass('is-active')){
		
			if(target == 'info'){
				updateInfo();
			}
			if(target == 'fields'){
				var fieldTarget = $("#fieldsTabs li.is-active a").data('tab');
				updateFieldList(fieldTarget);
			}
			if(target == 'worklogs'){
				var worklogTarget = $("#worklogsTabs li.is-active a").data('tab');
				updateWorklogList(worklogTarget);
			}
			if(target == 'tasks'){
				var taskTarget = $("#tasksTabs li.is-active a").data('tab');
				updateTaskList(taskTarget);
			}
			$('#farmContentContainer #farmTabs .is-active').switchClass('is-active','');
			$(this).parent().switchClass('','is-active');
			$('#farmContentContainer .main-tab-content.is-active').slideUp(300, function(){
				$(this).removeClass('is-active');
				$('#farmContentContainer .main-tab-content[data-tab="'+target+'"]').slideDown(300, function(){
					$(this).addClass('is-active');
				}).fadeIn(300);
			}).fadeOut(300);
		}
	});
	
	$('#fieldsContent #fieldsTabs li a').click(function(){
		var target = $(this).data('tab');
		if($('#fieldsContent div[data-tab="'+target+'"]').hasClass('is-active')){
			
		}
		else{
			updateFieldList(target);
			$('#fieldsContent #fieldsTabs .is-active').switchClass('is-active','');
			$(this).parent().switchClass('','is-active');
			$('#fieldsContent div.is-active').slideUp(300, function(){
				$(this).removeClass('is-active');
				$('#fieldsContent div[data-tab="'+target+'"]').slideDown(300, function(){
					$(this).addClass('is-active');
				}).fadeIn(300);
			}).fadeOut(300);
		}
	});
	
	$('#worklogsContent #worklogsTabs li a').click(function(){
		var target = $(this).data('tab');
		var action = $(this).data('action');
		if(target){
			if($('#worklogsContent div[data-tab="'+target+'"]').hasClass('is-active')){

			}
			else{
				updateWorklogList(target);
				$('#worklogsContent #worklogsTabs .is-active').switchClass('is-active','');
				$(this).parent().switchClass('','is-active');
				$('#worklogsContent div.is-active').slideUp(300, function(){
					$(this).removeClass('is-active');
					$('#worklogsContent div[data-tab="'+target+'"]').slideDown(300, function(){
						$(this).addClass('is-active');
					}).fadeIn(300);
				}).fadeOut(300);
			}
		}
		else if(action == 'newWorklog'){
			
			if(!$(this).parent().hasClass('is-disabled')){
				var farm_id = $("#data").data('farmId');;
				getModal('farms','newWorklog',{farmId:farm_id}, function(html){
					var modalDiv = $('<div></div>').css({opacity:0}).addClass('modal');
					$(modalDiv).html(html);
					$("#modal").append($(modalDiv));
					$(modalDiv).css({opacity:'0'}).addClass('is-active').animate({opacity:'1'},
						{duration: 200, complete:function(){
								$('#modal #worklogName').focus();
								$(document).on( "keydown", "#modal #worklogName",function(event){if(event.which == 13) {
										event.stopImmediatePropagation();
										event.preventDefault();
										worklogNew(); }else if(event.which == 27){ $('.modal.is-active').fadeOut(200,function(){$(this).remove();});
									} });
								$(document).on( "click", "#modal #worklogNameButton",function(event){
										event.stopImmediatePropagation();
										event.preventDefault();
										worklogNew(); });
					}});
				});
				
				
				
				
			}
		}
	});
	
	
	//task
	$('#tasksContent #tasksTabs li a').click(function(){
		var target = $(this).data('tab');
		var action = $(this).data('action');
		
		if(target){
			if(!$('#tasksContent div[data-tab="'+target+'"]').hasClass('is-active')){
				updateTaskList(target);
				$('#tasksContent #tasksTabs .is-active').switchClass('is-active','');
				$(this).parent().switchClass('','is-active');
				$('#tasksContent div.is-active').slideUp(300, function(){
					$(this).removeClass('is-active');
					$('#tasksContent div[data-tab="'+target+'"]').slideDown(300, function(){
						$(this).addClass('is-active');
					}).fadeIn(300);
				}).fadeOut(300);
			}
		}
		else if(action == 'newTask'){
			
			if(!$(this).parent().hasClass('is-disabled')){
				var farm_id = $("#data").data('farmId');;
				getModal('farms','newTask',{farmId:farm_id}, function(html){
					var modalDiv = $('<div></div>').css({opacity:0}).addClass('modal');
					$(modalDiv).html(html);
					$("#modal").append($(modalDiv));
					$(modalDiv).css({opacity:'0'}).addClass('is-active').animate({opacity:'1'},
						{duration: 200, complete:function(){
								$('#modal #worklogName').focus();
								
								$(document).on('click','#statusButtons .button',function(){
									if(!$(this).hasClass('is-hovered')){
										$("#statusButtons .is-hovered").switchClass('is-hovered','is-outlined',300);
										$(this).switchClass('is-outlined','is-hovered',300);
									}
								});
								
								
								$(document).on( "click", "#modal #addTask",function(event){ 
									event.stopImmediatePropagation();
									event.preventDefault();
									taskNew();
								});
					}});
				});
				
			}
		}
	});
});




//###### INFO ######\\\

function updateInfo() {
	var farmId = $("#data").data('farmId');
	var token = $('#data').data('token');
	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farmId,
		data:{_token:token},
		success:function(data){
			data = JSON.parse(data);
			var farm = data.farm;
			
			$('#members #ownerName').text(farm.farm_owner.name);
			$('#members .worker').each(function(){$(this).remove();});
			for(var key in farm.workers){
				var worker = farm.workers[key];
				var workerHtml = `<p class="has-text-info is-pulled-left name worker" ><span class="icon"><i class="fas fa-tractor"></i></span><span> ${worker.name}</span></p>`;
				$('#members .is-clearfix').before(workerHtml);
			}
			if($('#seasonNumber').text() != (':. '+farm.season+' .:')){
				$('#seasonNumber').fadeOut(500,function(){
					$(this).text(':. '+farm.season+' .:');
					$(this).fadeIn(500);
				});
			}
		}
	});
}

function nextSeason(){
	var farmId = $('#data').data('farmId');
	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farmId+'/next-season',
		data:{_token:$('#data').data('token')},
		success:function(data){
			data = JSON.parse(data);
			var season = data.response.season;
			if($('#seasonNumber').text() != (':. '+season+' .:')){
				$('#seasonNumber').fadeOut(500,function(){
					$(this).text(':. '+season+' .:');
					$(this).fadeIn(500);
				});
			}
		}
	});
}


//###### FARM ######\\\

function newFarm(evt){
	$('#newModal').addClass('is-active');
	$('#newModal input[name="farmName"]').focus();
	$("#newCreate").click(function(evt){
		
		$('#newModal .help').each(function(){$(this).remove();});
		evt.stopImmediatePropagation();
		evt.preventDefault();
		var formData = getFormData($('#newFarmForm'));
		$.ajax({
			type: "POST",
			url: "/farms",
			data: formData,
			success: showNewFarm
		});
					
	});
	$("#newClose").click(function(){
		$('#newModal input[name="farmName"]').val('');
		$('#newModal').removeClass('is-active');
	});
}

function showNewFarm(data, textStatus, jqXHR){
	data = JSON.parse(data);
	
	if(data.status == 'success'){
		var bottomRow = $('#farms .columns').last();
		
		if(bottomRow.length > 0){
			if($(bottomRow).html().length > 0)
			{

				var numInRow = $(bottomRow).children('.column').length;
				var lastInRow  = $(bottomRow).children('.column').last();
				
				if(numInRow == 3){
					
					$(bottomRow).after('<div class="columns">'+data.response+'</div>');
				}
				else if(numInRow == 0){
					$(bottomRow).html(data.response);
				}		
				else{
					
					$(lastInRow).after(data.response);
				}
			}
			else{
				$(bottomRow).html(data.response);
			}
		}
		else{
			$("#farms").html('<div class="columns">'+data.response+'</div>');
		}
		$('#newModal').removeClass('is-active');
		$('#newModal input[name="farmName"]').val('');
	}
	else{
		//Errors
		var errorsHtml = '';
		for(var i = 0; i < data.errors.length; i++){
			errorsHtml += '<p class="help is-danger">'+data.errors[i]+'</p>';
		}
		$('#newModal input[name="farmName"]').parent('.control').after(errorsHtml);
	}
	
	
	return true;
}

function renameFarm(){
	var currName = $("#farmName h1").text();
	$("#farmName h1").hide();
	$("#farmName form .input:text").val(currName);
	$("#farmName form").show();
	$("#farmName form .input").focus();
}

function updateFarmName(evt){
	evt.stopImmediatePropagation();
	evt.preventDefault();
	
	$("#farmName .help").each(function(){$(this).remove()});
	var formData = getFormData($('#farmName form'));
	$.ajax({
		method:'post',
		url:'/farm/'+$("#farmId input").val(),
		data: formData,
		success: function(data){
			data = JSON.parse(data);
			if(data.status == 'success'){
				$('#farmName form').hide();
				$("#farmName form .input:text").val('');
				$("#farmName h1").text(data.response.name).show();
			}
			else{
				var errorsHtml = '';
				for(var i = 0; i < data.errors.length; i++){
					errorsHtml += '<p class="help is-danger">'+data.errors[i]+'</p>';
				}
				$("#farmName .field").first().before('<div class="field">'+errorsHtml+'</div>');
			}
		}		
	});
}

function cancelRename(){
	$("#farmName form").hide();
	$("#farmName h1").show();
	$("#farmName .help").each(function(){$(this).remove()});
}

function deleteFarm(){
	var extras = {};
	extras.farmId = $("#farmId input").val();
	getModal('farms','delete',extras);
}



//###### Field ######\\\

function updateFieldList(target){
	var formData = {
		_token:$('#token input').val()
	};
	if(target == 'trashedFields'){
		formData.trashed = true;
	}
	$.ajax({
		type:'post',
		url:'/ajax/fields',
		data:formData,
		success:function(data){
			data = JSON.parse(data);
			var fields = data.response.fields;
			var htmlString = '';
			for(var i = 0; i < fields.length; i++){
				var field = fields[i];
				if(target == 'trashedFields'){
					var date = new Date(field.deleted_at);
					var trashedDate = new Intl.DateTimeFormat('en-GB', { year: 'numeric', month: '2-digit', day: '2-digit'}).format(date);
					trashedDate = trashedDate.replace(/\//g,'-');
					var trashedTime = new Intl.DateTimeFormat('en-GB', { hour: '2-digit', minute: '2-digit'}).format(date);
					htmlString += `<div class="column is-one-fifth farmField is-unselectable" data-name="${field.name}" data-field-id="${field.id}"><p class="has-text-weight-bold is-marginless">${field.name}</p> <p class="is-size-7"><span class="icon"><i class="fas fa-trash-alt"></i></span><span> ${trashedTime}<br/>${trashedDate}</span></p></div>`;
				}
				else{
					htmlString += `<div class="column is-one-fifth farmField is-unselectable" data-name="${field.name}" data-field-id="${field.id}"><p class="has-text-weight-bold is-marginless">${field.name}</p> <p class="is-size-7">${field.crop.name}</p></div>`;
				}
			}
			
			$('.tab-content[data-tab="'+target+'"] #fields .columns').html(htmlString);
		}
	});
}

function fieldNewOrRename(){
	var type = $("#normFields #fieldNameButton").data('type');
	$("#normFields #fieldNameButton").addClass('is-loading');
	var newName = $("#normFields #fieldName").val();
	var fieldId = $("#normFields #fields .farmField.selected").data('fieldId');
	var formData = {
		_token:$("#token input").val(),
		fieldName:newName
	};
	
	if(newName.length > 0){
		if(type == 'edit'){
			formData._method='put';
			$.ajax({
				type:'post',
				url:'/ajax/field/'+fieldId,
				data: formData,
				success:function(data){
					data = JSON.parse(data);
					var field = data.response.field;
					var fields = data.response.fields;
					var previousId;
					
					if(fields.length > 1){
						for(var i = 0; i < fields.length; i++){
							if(fields[i].id == field.id){
								previousId = fields[(i-1)].id;
							}
						}
						
						if($('#normFields #fields .farmField[data-field-id="'+previousId+'"]').next().data('fieldId') == field.id){
							$("#normFields #fields .farmField.selected p").first().text(newName);
							$("#normFields #fieldNameButton").removeClass('is-loading');
						}
						else
						{
							var newDiv = $('<div></div>').css({opacity:'1',width:'0px','padding':'0.75rem 0 0.75rem 0',overflow:'hidden'}).addClass('selected column is-one-fifth farmField is-unselectable').attr({'data-name':field.name,'data-field-id':field.id});
							$(newDiv).html(`<p class="has-text-weight-bold is-marginless">${field.name}</p> <span class="is-size-7">${field.crop.name}</span>`);
							$('#normFields #fields .farmField[data-field-id="'+field.id+'"]').animate({width:'0%',padding:'0'},{duration:1000,easing:'easeInCirc',complete:function(){ 
									$(this).remove();
									$('#normFields #fields .farmField[data-field-id="'+previousId+'"]').after(newDiv);
									
									$(newDiv).animate({width:'20%',padding:'0.75rem'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
										$(this).css({overflow:'inherit'});
										$("#normFields #fieldNameButton").removeClass('is-loading');
									}});
									
							}});
							
						}
						
					}
					else
					{
						$("#normFields #fields .farmField.selected p").text(newName);
						$("#normFields #fieldNameButton").removeClass('is-loading');
					}
				}
			});
		}
		if(type == 'new'){
			
			$.ajax({
				type:'post',
				url:'/ajax/field',
				data: formData,
				success:function(data){
					data = JSON.parse(data);
					var field = data.response.field;
					var fields = data.response.fields;
					var previousId;
					var newDiv = $('<div></div>').css({opacity:'1',width:'0px','padding':'0.75rem 0 0.75rem 0',overflow:'hidden'}).addClass('column is-one-fifth farmField is-unselectable').attr({'data-name':field.name,'data-field-id':field.id}).html(`<p class="has-text-weight-bold is-marginless">${field.name}</p> <p class="is-size-7">${field.crop.name}</p>`);
					if(fields.length > 1){
						for(var i = 0; i < fields.length; i++){
							if(fields[i].id == field.id){
								previousId = fields[(i-1)].id;
							}
						}
						
						$('#normFields #fields .farmField[data-field-id="'+previousId+'"]').after(newDiv);

						$(newDiv).delay(500).animate({width:'20%',padding:'0.75rem'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
							
						}});
					}
					else
					{
						
						$('#normFields #fields .columns').append(newDiv);
						$(newDiv).delay(500).animate({width:'20%',padding:'0.75rem'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
								$(this).css({overflow: 'inherit'});
						}
						});
					}
					$("#normFields #fieldName").val('');
					$("#normFields #fieldNameButton").removeClass('is-loading');
				}
			});
		}
		
	}else{
		$("#normFields #fieldName").addClass('is-danger').after('<p class="help has-text-danger"></p>');
		$("#normFields .help").hide().text('Field Name Cannot Be Empty');
		$("#normFields .help").slideDown(100, function(){
			$(this).delay(1500).slideUp(100, function(){
				$(this).remove();
				$("#normFields #fieldName").removeClass('is-danger');
			});
			
		});
		$("#normFields #fieldNameButton").removeClass('is-loading');
	}
}

function fieldsTrash(){
	var fieldIds = [];
	$("#normFields #fields .farmField.selected").each(function(index){
		fieldIds.push({id:$(this).data('fieldId')});
	});
	
	if(fieldIds.length > 0){
		fieldIds = JSON.stringify(fieldIds);
		var formData = {
			_token:$('#token input').val(),
			_method:'delete',
			fields:fieldIds
		};
		
		$.ajax({
			type:'post',
			url:'/ajax/fields/trash',
			data:formData,
			success:function(){
				$("#normFields #fields .farmField.selected").each(function(){
					$(this).css({overflow:'hidden'});
					$(this).animate({width:'0%',padding:'0'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
						$(this).remove();
						
					}});
				});
				$("#fieldName").val('');
				$("#fieldNameButton").html('New Field');
				$("#fieldNameButton").data('type','new');
				$("#normFields #newField #moveToTrashOption, #normFields #selectedOptions").slideUp(100,function(){
					$(this).removeClass('opened');
					$("#newField").slideDown(100, function(){
						$(this).addClass('opened');
					});
				});
			}
		});
		
	}
}
function fieldsRecover(button){
	var fieldIds = [];
	$(button).addClass('is-loading').blur();
	$("#deletedFields #fields .farmField.selected").each(function(index){
		fieldIds.push({id:$(this).data('fieldId')});
	});
	
	if(fieldIds.length > 0){
		fieldIds = JSON.stringify(fieldIds);
		var formData = {
			_token:$('#token input').val(),
			_method:'put',
			fields:fieldIds
		};
		
		$.ajax({
			type:'post',
			url:'/ajax/fields/restore',
			data:formData,
			success:function(){
				$("#deletedFields #fields .farmField.selected").each(function(){
					$(this).css({overflow:'hidden'});
					$(this).animate({width:'0%',padding:'0'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
						$(this).remove();
						$(button).removeClass('is-loading');
						
					}});
				});
				if($('#deletedFields #selectedOptions').delay(700).hasClass('opened')){
					$('#deletedFields #selectedOptions').slideUp(100,function(){
						$(this).removeClass('opened');
						$("#deletedFields #emptyTrash").slideDown(100, function(){
							$(this).addClass('opened');
						});
					});
				}
				
			}
		});
		
	}
}
function emptyTrash(button,modalAccept){
	$(button).addClass('is-loading').blur();
	var deleteFields = [];
	if($(button).attr('id') == 'deleteButton')
	{
		$('#deletedFields .farmField.selected').each(function(){
			deleteFields.push({id:$(this).data('fieldId')});
		});
	}
	else{
		$('#deletedFields .farmField').each(function(){
			$(this).addClass('selected');
			deleteFields.push({id:$(this).data('fieldId')});
		});
	}
	if(typeof(modalAccept) == 'undefined'){
		
		//server: get all fields from worklog_fields with the field Id's selected, then get the worklog for each one. js:each worklog needs to have it's name/season shown.


		var modal = $('<div></div>').addClass('modal').html(
				`<div class="modal-background"></div>
				<div class="modal-card ">
				  <header class="modal-card-head has-background-danger">
					<p class="modal-card-title has-text-white">Delete Field${deleteFields.length > 1? 's':''}</p>
					<div class="delete"></div>
				  </header>
				  <section class="modal-card-body">
					  <p class="title is-5"><strong>Deleting Trashed Fields May Break One Or More Of Your Worklogs</strong></p>
					  <p class="subtitle is-6">Make Sure You Have Deleted The Worklog That Conains Any Of The Selected Fields</p>
					  <div class="field is-grouped">
						  <div class="control">
							  <button class="button is-danger is-large" id="deleteFieldYes">Yes</button>
						  </div>
						  <div class="control">
							  <button class="button is-info is-large" id="deletFieldeNo">Cancel</button>
						  </div>
					  </div>
				  </section>
				</div>`
				);
		$("#modal").append($(modal));
		$(modal).css({opacity:'0'}).addClass('is-active').animate({opacity:'1'},
		{duration: 200, complete:function(){
				$(this).addClass('is-active');
				var yes = $(this).find('#deleteFieldYes');
				var no = $(this).find('#deletFieldeNo');
				var background = $(this).find('.modal-background');
				var close = $(this).find('.delete');
				var self=$(this);
				$(yes).click(function(){
					emptyTrash(button,'yes');
					$(self).fadeOut(200, function(){
						$(self).remove();
						$(button).removeClass('is-loading').blur();
						$('#deletedFields .farmField.selected').each(function(){
							$(this).removeClass('selected');
						});
					});
				});

				$(no).click(function(){
					$(self).fadeOut(200, function(){
						$(self).remove();
						$(button).removeClass('is-loading').blur();
						$('#deletedFields .farmField.selected').each(function(){
							$(this).removeClass('selected');
						});
					});
				});
				$(background).click(function(){
					$(self).fadeOut(200, function(){
						$(self).remove();
						$(button).removeClass('is-loading').blur();
						$('#deletedFields .farmField.selected').each(function(){
							$(this).removeClass('selected');
						});
					});
				});
				$(close).click(function(){
					$(self).fadeOut(200, function(){
						$(self).remove();
						$(button).removeClass('is-loading').blur();
						$('#deletedFields .farmField.selected').each(function(){
							$(this).removeClass('selected');
						});
					});
				});

			}
		});
	}
	else if(modalAccept == 'yes'){
	
		

		deleteFields = JSON.stringify(deleteFields);

		var formData = {
			_token:$('#token input').val(),
			_method:'delete',
			fields:deleteFields
		};

		$.ajax({
			type:'post',
			url:'/ajax/fields/delete',
			data:formData,
			success:function(){
				if($(button).attr('id') == 'deleteButton')
				{
					$('#deletedFields .farmField.selected').each(function(){
						$(this).css({display:'block',overflow:'hidden'});
						$(this).animate({width:'0%',padding:'0'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
							$(this).remove();
						}});
					});
				}else{
					$('#deletedFields .farmField').each(function(){
						$(this).css({overflow:'hidden'});
						$(this).animate({width:'0%',padding:'0'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
							$(this).remove();
						}});
					});
				}
				$(button).removeClass('is-loading');
				if($('#selectedOptions').hasClass('opened')){
					$('#selectedOptions').slideUp(100,function(){
						$(this).removeClass('opened');
						$("#emptyTrash").slideDown(100, function(){
							$(this).addClass('opened');
						});
					});
				}
			}
		});
	}
}

function fieldClick(field){
	
	var selectable = parseInt($("#normFields #fields").data('selectable'));
	
	if(selectable == 1){
		$(field).toggleClass('selected');
		if($('#normFields .farmField.selected').length == 1){
			if(!$("#normFields #newField").hasClass('opened')){
				$("#normFields #options .opened").slideUp(100, function(){
					$(this).removeClass('opened');
					$("#normFields #newField").slideDown(100).addClass('opened');
				});
			}
			$("#normFields #newField #moveToTrashOption").slideDown(100);
			$("#fieldNameButton").html('Edit Field');
			$("#fieldNameButton").data('type','edit');
			$("#fieldName").val($('#normFields .farmField.selected').data('name'));
		}
		else if($('#normFields .farmField.selected').length > 1){
			$("#normFields #newField").slideUp(100, function(){
				$(this).removeClass('opened');
				$("#normFields #selectedOptions").slideDown(100).addClass('opened');
			});

		}
		else
		{
			$("#fieldName").val('');
			$("#fieldNameButton").html('New Field');
			$("#fieldNameButton").data('type','new');
			$("#newField").slideDown(100).addClass('opened');
			$("#normFields #newField #moveToTrashOption").slideUp(100);
		}
	}
}

function fieldClickTrashed(field){
	
	var selectable = parseInt($("#deletedFields #fields").data('selectable'));
	
	if(selectable == 1){
		
		$(field).toggleClass('selected');
		var selectedLength = $('#deletedFields .farmField.selected').length;
		if(selectedLength > 0){
			
			$("#deletedFields #emptyTrash").slideUp(100, function(){
				$(this).removeClass('opened');
				$("#recoverButton").text('Recover Field'+(selectedLength > 1? 's':''));
				$("#deleteButton").text('Delete Field'+(selectedLength > 1? 's':''));
				$("#deletedFields #selectedOptions").slideDown(100).addClass('opened');
			});
		}
		else
		{
			$("#deletedFields #selectedOptions").slideUp(100, function(){
				$(this).removeClass('opened');
				$("#deletedFields #emptyTrash").slideDown(100).addClass('opened');
			});
		}
	}
}



//###### Worklog ######\\\

function worklogNew(){
	var farmId = $("#data").data('farmId');
	var formData = {
		_token:$("#data").data('token'),
		name:$("#modal #worklogName").val()
	};
	
	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farmId+'/worklogs/store',
		data:formData,
		success:function(data){
			data = JSON.parse(data);
			var worklog = data.response.worklog;
			var user = data.response.user;
			var farm = data.response.farm;
			$('.modal.is-active').animate({opacity:'0'},{duration:200,complete:function(){
					$(this).remove();
					var newWorklog = $('<div></div>').css({overflow:'hidden', display: 'none', width:'0%',padding:'0'}).addClass('column is-one-third');
					
					
						var updateWorklogsHtml = `
							<div class="card has-text-centered">
								<a href="/farm/${farmId}/worklog/${worklog.id}" class="has-text-centered">
									<header	class="card-header has-text-centered">
										<p class="card-header-title has-text-centered">`;
						updateWorklogsHtml += (worklog.name)? worklog.name+' - Season '+worklog.season:('Season '+worklog.season);
						updateWorklogsHtml += `</p></header>
								</a>`;
						if(user.id == farm.owner){
							updateWorklogsHtml += `<div class="card-footer">
														<a class="card-footer-item">Re Name</a>
														<a class="card-footer-item has-text-danger">Trash</a>
													</div>`;

						}
						updateWorklogsHtml += `</div>
										</div>`;
								
					$(newWorklog).html(updateWorklogsHtml);
					$('#normalWorklogs p.showing').fadeOut(500, function(){
						$('#normalWorklogs .columns').prepend($(newWorklog));
						
						$(newWorklog).fadeIn(200).animate({width:'33.3333%',padding:'0.75rem'},{duration:1000,easing:'easeInCirc'});
					});
					
			}});
		}
	});
}

function worklogDoRename(worklog_id){
	var farm_id = $("#data").data('farmId');
	var formData = {
		_token:$("#data").data('token'),
		_method:'put',
		name:$("#modal #worklogName").val()
	};
	
	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farm_id+'/worklog/'+worklog_id,
		data:formData,
		success:function(data){
			data = JSON.parse(data);
			var worklog = data.response.worklog;
			var user = data.response.user;
			var farm = data.response.farm;
			$('.modal.is-active').animate({opacity:'0'},{duration:200,complete:function(){
					$(this).remove();
					var updateWorklogTitle = (worklog.name)? worklog.name+' - Season '+worklog.season:'Season '+worklog.season;
					$('.worklog[data-worklog-id="'+worklog_id+'"] .card-header-title').text(updateWorklogTitle);
			}});
		}
	});
}

function worklogRename(button){
	var farm_id = $("#data").data('farmId');
	var worklogContainer = $(button).parents('.worklog');
	var worklog_Id = $(worklogContainer).data('worklogId');
	getModal('farms','newWorklog',{farmId:farm_id,worklogId:worklog_Id}, function(html){
		var modalDiv = $('<div></div>').css({opacity:0}).addClass('modal');
		$(modalDiv).html(html);
		$("#modal").append($(modalDiv));
		$(modalDiv).css({opacity:'0'}).addClass('is-active').animate({opacity:'1'},
			{duration: 200, complete:function(){
					$('#modal #worklogName').focus();
					$(document).on( "keydown", "#modal #worklogName",function(event){if(event.which == 13) { worklogDoRename(worklog_Id); }else if(event.which == 27){ $('.modal.is-active').fadeOut(200,function(){$(this).remove();}); } });
					$(document).on( "click", "#modal #worklogNameButton",function(){ worklogDoRename(worklog_Id); });
		}});
	});
}

function  worklogTrash(button){
	var farmId = $("#data").data('farmId');
	var worklogContainer = $(button).parents('.worklog');
	var worklogId = $(worklogContainer).data('worklogId');
	var formData = {
		_token:$('#data').data('token'),
		_method:'delete'
	};

	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farmId+'/worklog/'+worklogId+'/trash',
		data:formData,
		success:function(data){
			data = JSON.parse(data);
			var worklogs = data.response.farm.worklogs;
			var user = data.response.user;
			var farm = data.response.farm;
			
			$(button).parents('.worklog').css({overflow:'hidden'});
			$(button).parents('.worklog').animate({width:'0%',padding:'0'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
				$(this).remove();
				if(worklogs.length < 1)
				{
					$('#normalWorklogs #noWorklogs').fadeIn(500).addClass('showing');
					if(farm.fields.length < 1 && user.id == farm.owner){
						$('#normalWorklogs #noFields').fadeIn(500).addClass('showing');
					}
				}
			}});
		}
	});
	
}

function worklogRecover(button){
	var farmId = $("#data").data('farmId');
	var worklogId = $(button).parents('.worklog').data('worklogId');
	var formData = {
		_token:$('#data').data('token'),
		_method:'put',
	};

	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farmId+'/worklog/'+worklogId+'/restore',
		data:formData,
		success:function(){
			$(button).parents('.worklog').css({overflow:'hidden'});
			$(button).parents('.worklog').animate({width:'0%',padding:'0'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
				$(this).remove();
			}});
		}
	});
}

function  worklogDelete(button,modalAccept){
	var farmId = $("#data").data('farmId');
	var worklogContainer = $(button).parents('.worklog');
	var worklogId = $(worklogContainer).data('worklogId');
	
	if(typeof(modalAccept) == 'undefined'){
		
		var modal = $('<div></div>').addClass('modal').html(
				`<div class="modal-background"></div>
				<div class="modal-card ">
				  <header class="modal-card-head has-background-danger">
					<p class="modal-card-title has-text-white">Delete Worklog</p>
					<div class="delete"></div>
				  </header>
				  <section class="modal-card-body">
					  <p class="title is-5"><strong>Are You Sure, This Is Not Reversible</strong></p>
					  <p class="subtitle is-6">This Will Also Delete All Data Related To This Worklog</p>
					  <div class="field is-grouped">
						  <div class="control">
							  <button class="button is-danger is-large" id="deleteWorklogYes">Yes</button>
						  </div>
						  <div class="control">
							  <button class="button is-info is-large" id="deletWorklogNo">Cancel</button>
						  </div>
					  </div>
				  </section>
				</div>`
				);
		$("#modal").append($(modal));
		$(modal).css({opacity:'0'}).addClass('is-active').animate({opacity:'1'},
		{duration: 200, complete:function(){
				
				var yes = $(this).find('#deleteWorklogYes');
				var no = $(this).find('#deletWorklogeNo');
				var background = $(this).find('.modal-background');
				var close = $(this).find('.delete');
				var self=$(this);
				$(yes).click(function(){
					worklogDelete(button,'yes');
					$(self).fadeOut(200, function(){
						$(self).remove();
					});
				});

				$(no).click(function(){
					$(self).fadeOut(200, function(){
						$(self).remove();
					});
				});
				$(background).click(function(){
					$(self).fadeOut(200, function(){
						$(self).remove();
					});
				});
				$(close).click(function(){
					$(self).fadeOut(200, function(){
						$(self).remove();
					});
				});

			}
		});
	}
	else if(modalAccept == 'yes'){
	
		
		var formData = {
			_token:$('#data').data('token'),
			_method:'delete'
		};

		$.ajax({
			type:'post',
			url:'/ajax/farm/'+farmId+'/worklog/'+worklogId+'/delete',
			data:formData,
			success:function(){
				$(button).parents('.worklog').css({overflow:'hidden'});
				$(button).parents('.worklog').animate({width:'0%',padding:'0'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
					$(this).remove();
				}});
			}
		});
	}
}

function updateWorklogList(target){
	var farmId = $("#data").data('farmId');
	var formData = {
		_token:$('#data').data('token')
	};
	
	if(target == 'trashedWorklogs'){
		formData.trashed = true;
	}
	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farmId+'/worklogs',
		data:formData,
		success:function(data){
			data = JSON.parse(data);
			
			var worklogs = data.response.farm.worklogs;
			var farm = data.response.farm;
			var user = data.response.user;
			var htmlString = '';
			
			if(worklogs.length > 0){
				for(var i = 0; i < worklogs.length; i++){
					var worklog = worklogs[i];
					htmlString += `<div class="column is-one-third worklog"  data-worklog-id="${worklog.id}">

										<div class="card has-text-centered ">
											<a href="/farm/${farm.id}/worklog/${worklog.id}" class="has-text-centered">
												<header	class="card-header has-text-centered">
													<p class="card-header-title has-text-centered">`;
					htmlString +=						(worklog.name)? worklog.name+' - Season '+worklog.season:'Season '+worklog.season;
					htmlString +=					`</p>
												</header>
											</a>`;
					if(user.id == farm.owner){
						
						if(target != 'trashedWorklogs'){
							htmlString +=	`<div class="card-footer">
												<a class="card-footer-item worklogRenameButton">Re Name</a>
												<a class="card-footer-item has-text-danger worklogTrashButton">Trash</a>
											</div>`;
						} else {
							htmlString +=	`<div class="card-footer">
												<a class="card-footer-item worklogRecoverButton">Restore</a>
												<a class="card-footer-item has-text-danger worklogDeleteButton">Delete</a>
											</div>`;
						}
					}
					htmlString +=			`</div>
										</div>`;
				}
				$('#worklogsContent .tab-content[data-tab="'+target+'"] .columns').html(htmlString);
			}
			else if(target == 'normalWorklogs'){
				
				$('#normalWorklogs #noWorklogs').fadeIn(500).addClass('showing');
				
				if(farm.fields.length < 1 && (user.id == farm.owner || user.role == 1)){
					$('#worklogsTabs li').first().switchClass('','is-disabled',300);
					$('#normalWorklogs #noFields').switchClass('is-hidden','showing',300);
				}
				else{
					$('#normalWorklogs #noFields').switchClass('showing','is-hidden',300);
					$('#worklogsTabs li').first().switchClass('is-disabled','',300);
				}
			}
		}
	});
}

function taskNew(){
	var farmId = $("#data").data('farmId');
	var taskTitle = $('#taskTitle').val();
	var taskContent = $('#taskDescription').val();
	var taskStatus = $('#statusButtons .is-hovered').data('status');
	//make the ajax call
	
	var formData = {
		_token:$('#data').data('token'),
		title:taskTitle,
		content:taskContent,
		status: taskStatus
	};
	
	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farmId+'/farmTask/store',
		data:formData,
		success:function(data){
			data = JSON.parse(data);
			var farmTask = data.response.farmTask;
			$('.modal.is-active').css({opacity:'1'}).animate({opactiy:'0'},{duration:300,complete:function(){
				$(this).remove();
			}});
			
			
			
			var newTaskHtml = `<div class="card farmTask" data-task-id="${farmTask.id}">
					<header class="card-header has-background-${farmTask.bgColour} has-text-centered">
						<p class="card-header-title has-text-${farmTask.txtColour} is-unselectable has-text-centered">${farmTask.title}</p>
					</header>
				</div>`;
			
			var newTaskColumnDiv = $('<div></div>').css({opacity:'1',width:'0px','padding':'0.75rem 0 0.75rem 0',overflow:'hidden'}).addClass('column is-one-third').html(newTaskHtml);
			if($('#normTasks #noTasks').hasClass('showing')){
				$('#normTasks #noTasks').switchClass('showing','is-hidden',300);
			}
			$('#normTasks .columns').prepend(newTaskColumnDiv);
			$(newTaskColumnDiv).animate({width:'33.3333%',padding:'0.75rem'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
				$(this).css({overflow:'inherit'});

			}});
		}
	});
	
}

function taskView(task){
	var farm_id = $("#data").data('farmId');
	var showTaskId = $(task).data('taskId');
	getModal('farms','showTask',{farmId:farm_id,farmTaskId:showTaskId}, function(html){
		var modalDiv = $('<div></div>').css({opacity:0}).addClass('modal');
		$(modalDiv).html(html);
		$("#modal").append($(modalDiv));
		$(modalDiv).css({opacity:'0'}).addClass('is-active').animate({opacity:'1'},
			{duration: 200});
	});
	
	
}

function taskEdit(task){
	var farm_id = $("#data").data('farmId');
	var taskId = $(task).data('taskId');
	task = $(task).parents('.modal-card');
	
	var title = $(task).find('.modal-card-head p').first().text();
	var titleHtml = $(task).find('.modal-card-head').first().html();
	var content = $(task).find('.modal-card-body p').first().text();
	
	$(task).find('.delete').first().fadeOut(300, function(){
		$(task).find('.modal-card-head p').first().html(`<div class="control"><input type="text" name="title" class="input" value="${title}"/></div>`);
	
		$(task).find('.modal-card-body p').first().html(`<textarea name="description" class="textarea">${content}</textarea>`);
		$(task).find('#editTask').first().switchClass('is-primary','is-success', 300).text('Save').attr('id','saveEdit').parent('.control').after(`<div class="control is-expanded"><button class="button is-light is-fullwidth" id="cancelEdit">Cancel</button></div>`);
	});
	
	
	//save
	$(document).on("click","#saveEdit", function(){
		$(this).switchClass('', 'is-loading');
		var button = $(this);
		var formData = {
			_token:$("#data").data('token'),
			_method:'put',
			title:$(task).find('input[name="title"]').first().val(),
			content:$(task).find('textarea').first().val()
		};
		
		$.ajax({
			type:'post',
			url:'/ajax/farm/'+farm_id+'/farmTask/'+taskId,
			data: formData,
			success:function(data){
				data = JSON.parse(data);
				var farmTask = data.response.farmTask;
				$(task).find('.modal-card-head p').first().html(farmTask.title);
				$(task).find('.modal-card-body p').first().html(farmTask.content);
				$(task).find('.delete').first().fadeIn(300);
				$(button).switchClass('is-loading','',300);
				$(task).find("#saveEdit").first().switchClass('is-success','is-primary', 300).text('Edit Task').attr('id','editTask');
				$(task).find("#cancelEdit").parent().first().remove();
				$('#normTasks .farmTask[data-task-id="'+farmTask.id+'"]').find('.card-header-title').text(farmTask.title);
			}
		});
	});
	
	//cancel Edit
	
	$(document).on("click", "#cancelEdit", function(){
		$(this).parent('.control').remove();
		$(task).find("#saveEdit").first().switchClass('is-success','is-primary', 300).text('Edit Task').attr('id','editTask');
		$(task).find('.modal-card-head p').first().html(title);
		$(task).find('.modal-card-body p').first().html(content);
		$(task).find('.delete').first().fadeIn(300);
	});
}

function taskTrash(task){
	var farm_id = $("#data").data('farmId');
	var taskId = $(task).data('taskId');
	task = $(task).parents('.modal-card');
	
	var formData = {
		_token:$('#data').data('token'),
		_method:'delete'
	};
	
	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farm_id+'/farmTask/'+taskId+'/trash',
		data:formData,
		success:function(data){
			data = JSON.parse(data);
			var farmTasks = data.response.farmTasks;
			if(data.status == 'success'){
				$('.modal.is-active').fadeOut(300,function(){
					
					
					$('.farmTask[data-task-id="'+taskId+'"]').parent().css({'overflow':'hidden', opacity:'1'}).animate({width:'0%','padding':'0.75rem 0 0.75rem 0'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
						$(this).remove();
						console.log(farmTasks.length)
						if(farmTasks.length < 1){
							$('#normTasks #noTasks').switchClass('is-hidden','showing').fadeIn(300);
						}
					}});
				});
			}
		}
	});
}

function taskRecover(button){
	var farmId = $("#data").data('farmId');
	var taskId = $(button).data('taskId');
	var formData = {
		_token:$('#data').data('token'),
		_method:'put',
	};

	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farmId+'/farmTask/'+taskId+'/restore',
		data:formData,
		success:function(){
			$(button).parents('.column').first().css({overflow:'hidden'});
			$(button).parents('.column').first().animate({width:'0%',padding:'0'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
				$(this).remove();
			}});
		}
	});
}

function  taskDelete(button,modalAccept){
	var farmId = $("#data").data('farmId');
	var taskId = $(button).data('taskId');
	
	if(typeof(modalAccept) == 'undefined'){
		
		var modal = $('<div></div>').addClass('modal').html(
				`<div class="modal-background"></div>
				<div class="modal-card ">
				  <header class="modal-card-head has-background-danger">
					<p class="modal-card-title has-text-white">Delete Task</p>
					<div class="delete"></div>
				  </header>
				  <section class="modal-card-body">
					  <p class="title is-5"><strong>Are You Sure? This Is Not Reversible</strong></p>
					  <div class="field is-grouped">
						  <div class="control">
							  <button class="button is-danger is-large" id="deleteTaskYes">Yes</button>
						  </div>
						  <div class="control">
							  <button class="button is-info is-large" id="deleteTaskNo">Cancel</button>
						  </div>
					  </div>
				  </section>
				</div>`
				);
		$("#modal").append($(modal));
		$(modal).css({opacity:'0'}).addClass('is-active').animate({opacity:'1'},
		{duration: 200, complete:function(){
				
				var yes = $(this).find('#deleteTaskYes');
				var no = $(this).find('#deleteTaskNo');
				var background = $(this).find('.modal-background');
				var close = $(this).find('.delete');
				var self=$(this);
				$(yes).click(function(){
					taskDelete(button,'yes');
					$(self).fadeOut(200, function(){
						$(self).remove();
					});
				});

				$(no).click(function(){
					$(self).fadeOut(200, function(){
						$(self).remove();
					});
				});
				$(background).click(function(){
					$(self).fadeOut(200, function(){
						$(self).remove();
					});
				});
				$(close).click(function(){
					$(self).fadeOut(200, function(){
						$(self).remove();
					});
				});

			}
		});
	}
	else if(modalAccept == 'yes'){
	
		
		var formData = {
			_token:$('#data').data('token'),
			_method:'delete'
		};

		$.ajax({
			type:'post',
			url:'/ajax/farm/'+farmId+'/farmTask/'+taskId+'/delete',
			data:formData,
			success:function(){
				$(button).parents('.column').first().css({overflow:'hidden'});
				$(button).parents('.column').first().animate({width:'0%',padding:'0'}, {duration:1000,easing:'easeInCirc',complete:function(){ 
					$(this).remove();
					
				}});
			}
		});
	}
}

function changeTaskStatus(button){
	var farmId = $("#data").data('farmId');
	var taskId = $("#farmTaskModal").data('taskId');
	if(!$(button).hasClass('is-hovered')){
		$("#statusButtons .is-hovered").switchClass('is-hovered','is-outlined',300);
		$(button).switchClass('is-outlined','is-hovered is-loading',{duration:300,complete:function(){
				//make the call to change the status
				var formData = {
					_token:$('#data').data('token'),
					_method:'put',
					status:$(button).data('status')
				};
				self = $(button);
				$.ajax({
					type:'post',
					url:'/ajax/farm/'+farmId+'/farmTask/'+taskId,
					data:formData,
					success:function(data){
						data = JSON.parse(data);

						var farmTask = data.response.farmTask;
						$(self).removeClass('is-loading');
						$('.modal.is-active header').attr('class','modal-card-head has-background-'+farmTask.bgColour)
						$('.modal.is-active .modal-card-title').attr('class', 'modal-card-title has-text-centered has-text-'+farmTask.txtColour);

						$('#normTasks .farmTask[data-task-id="'+farmTask.id+'"]').find('.card-header').first().attr('class', 'card-header has-text-centered has-background-'+farmTask.bgColour);
						$('#normTasks .farmTask[data-task-id="'+farmTask.id+'"]').find('.card-header-title').first().attr('class', 'card-header-title is-unselectable has-text-centered has-text-'+farmTask.txtColour);

					}
				});
			}
		});
	}
}

function updateTaskList(target){
	var farmId = $("#data").data('farmId');
	var formData = {
		_token:$('#data').data('token')
	};
	var taskClass = 'farmTask';
	if(target == 'trashedTasks'){
		formData.trashed = true;
		taskClass = 'farmTaskTrashed';
	}
	$.ajax({
		type:'post',
		url:'/ajax/farm/'+farmId+'/farmTasks',
		data:formData,
		success:function(data){
			data = JSON.parse(data);
			
			var tasks = data.response.farmTasks;
			var farm = data.response.farm;
			var user = data.response.user;
			var htmlString = '';
			
			if(tasks.length > 0){
				for(var i = 0; i < tasks.length; i++){
					var task = tasks[i];
					htmlString += `<div class="column is-one-third">

										<div class="card has-text-centered ${taskClass}" data-task-id="${task.id}">
											
												<header	class="card-header has-text-centered has-background-${task.bgColour}">
													<p class="card-header-title has-text-centered has-text-${task.txtColour}">${task.title}</p>
												</header>
											`;
					if(user.id == farm.owner || user.role == 1){
						
						if(target == 'trashedTasks'){
							
							htmlString +=	`<footer class="card-footer">
												<a class="card-footer-item taskRecoverButton" data-task-id="${task.id}">Restore</a>
												<a class="card-footer-item has-text-danger taskDeleteButton" data-task-id="${task.id}">Delete</a>
											</footer>`;
						}
					}
					htmlString +=			`</div>
										</div>`;
				}
				if($('#normTasks #noTasks').hasClass('showing')){
					$('#normTasks #noTasks').switchClass('showing','is-hidden',300).fadeOut(300);
				}
				
				$('#tasksContent .tab-content[data-tab="'+target+'"] .columns').html(htmlString);
			}
			else if(target == 'normalTasks'){
				
				$('#normTasks #noTasks').switchClass('is-hidden','showing',300).fadeIn(300);
				
			}
		}
	});
}
