$(document).ready(function(){
	//display
	isExpandable();
	
	//farm
	$("#new").click(function(evt){ newFarm(evt); });
	$("#deleteFarm").click(function(){ deleteFarm(); });
	$("#rename").click(function(){ renameFarm(); });
	$('#cancelRename').click(function(){ cancelRename(); });	
	
	//field
	$('#newFieldForm').submit(function(evt){ newField(evt);	});
	
});
optionEvents();



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
				console.log(numInRow)
				if(numInRow == 3){
					console.log('new Row');
					$(bottomRow).after('<div class="columns">'+data.response+'</div>');
				}
				else if(numInRow == 0){
					$(bottomRow).html(data.response);
				}		
				else{
					console.log('same Row');
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
		url:'/farms/'+$("#farmId input").val(),
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

function fieldHover(field){
	$(field).addClass('has-background-light');
	$(field).children().first().children('.hidden').show();
}

function fieldUnhover(field){
	$(field).removeClass('has-background-light');
	$(field).children().first().children('.hidden').hide();
}

function newField(evt){
	evt.stopImmediatePropagation();
	evt.preventDefault();
	if($("#newErrors").length > 0){
		$("#newErrors").remove();
	}
	var formData = getFormData($('#newFieldForm'));
	$.ajax({
		type: "POST",
		url: "/ajax/field",
		data: formData,
		success: showNewField
	});
	
}
function showNewField(data, textStatus, jqXHR){
	data = JSON.parse(data);
	
	if(data.status == 'success'){
		var expandable = $('#fields').parents('.expandable').first();
		if($('#fieldsNotification').length > 0){
			
			if($('#worklogNotification').length > 0){
				$('#worklogNotification').fadeOut(400, function (){ $('#newWorklogContent').fadeIn(400); });
			}
			$('#fieldsNotification').fadeOut(500, function(){
				
				
				$('#fields').append(data.response);
				resizeContainer(expandable);
				isExpandable();
			});

		}
		else{
			if($('#worklogNotification').length > 0){
				$('#worklogNotification').fadeOut(400, function (){ $('#newWorklogContent').fadeIn(400); });
			}
			
			$('#fields').append(data.response);
			resizeContainer(expandable);
			isExpandable();
		}
		$('#newFieldForm input[name="name"]').val('');
		$('#newFieldForm select').val('Crop');
		$('#newFieldForm select').first('option').attr('selected');
	}
	else
	{
		//erros
		var errorsHtml = '';
		for(var i = 0; i < data.errors.length; i++){
			errorsHtml += '<p class="help is-danger">'+data.errors[i]+'</p>';
		}
		$("#newFieldForm .field").last().after('<div class="field" id="newErrors">'+errorsHtml+'</div>');
		
		
	}
}

function editField(field){
	$('.farmField .options').each(function(){ $(this).css('visibility','hidden');});	
	
	var id = $(field).val();
	var row = $(field).parents('.farmField');
	var fieldName = $(row).find(".fieldName").text();
	var fieldCrop = $(row).find('.fieldCrop').text();
	var editForm = $("#editFieldForm").html();
	
	$(row).hide();
	$(row).after('<div class="column edit"><form method="post" id="editField">'+editForm+'</form></div>');
	
	var editField = $("form#editField");
	
	$("form#editField #fieldName").val(fieldName);
	
	var cropOption = $("form#editField #fieldCrop option").filter(function(){
		return $(this).html() == fieldCrop;
	}).val();
	$('form#editField #saveField').val(id);
	$("form#editField #fieldCrop").val(cropOption);
	$('form#editField #cancelEditField').click(function(){ cancelEditField($(this)); });
	$('form#editField #saveField').click(function(evt){ updateField(evt,$(this)); });
}

function cancelEditField(button){
	var row = $(button).parents('.edit').first();
	var previous = $(row).prev('.farmField');
	$(previous).show();
	$(previous).next('.edit').remove();
	$('.farmField .options').each(function(){ $(this).css('visibility','visible');});
}

function updateField(evt, button){
	evt.stopImmediatePropagation();
	evt.preventDefault();
	$('form#editField .help').each(function(){$(this).remove();});
	var id = $(button).val();
	var formData = getFormData($('form#editField'));
	
	$.ajax({
		type: "POST",
		url: "/ajax/field/"+parseInt(id),
		data: formData,
		success: showUpdatedField
	});
	
}

function showUpdatedField(data, textStatus, jqXHR){
	data = JSON.parse(data);
	if(data.status == 'success'){
		$('#field_'+data.response.id).find('.fieldName').text(data.response.name);
		$('#field_'+data.response.id).find('.fieldCrop').text(data.response.crop.name);
		$('#field_'+data.response.id).show();
		$('#field_'+data.response.id).next('.edit').remove();
		$('.farmField .options').each(function(){ $(this).css('visibility','visible');});
	}
	else{
		var errorsHtml = '';
		for(var i = 0; i < data.errors.length; i++){
			errorsHtml += '<p class="help is-danger">'+data.errors[i]+'</p>';
		}	
		$('form#editField .field').first().before('<div class="field">'+errorsHtml+'</div>');
	}
}

function deleteField(button){
	var extras = {};
	extras.fieldId = $(button).val();
	getModal('fields','delete',extras);
}
function deleteFieldConf(form){
	var formData = getFormData($(form));
	var action = $(form).attr('action');
	$.ajax({
		type:'post',
		url:action,
		data: formData,
		success: deleteFieldReturn
	});
}

function deleteFieldReturn(data){
	data = JSON.parse(data);
	if(data.status == 'success'){
		$('#field_'+data.response.id).fadeOut(800, function(){$(this).remove();resizeContainer($("#fieldsBox"));isExpandable();});
		$('#deleteModal').fadeOut(300,function(){$(this).remove();});
		if($("#fields").find('columns').length < 1){
			$('#fieldsNotification').fadeIn(800);
			$('#newWorklogContent').fadeOut(400, function(){$('#worklogNotification').fadeIn(400);});
		}
	}
	else
	{
		var errorsHtml = '';
		for(var i = 0; i < data.errors.length; i++){
			errorsHtml += '<p class="help is-danger">'+data.errors[i]+'</p>';
		}
		$('#deleteModal .modal-card-body').find('.title').after(errorsHtml);
	}
}





function isExpandable(){
	$('.expandable').each(function(){
		
		var contentHeight = $(this).find('.expandContent').first().height();
		var containerHeight = $(this).find('.expandContainer').first().height();
		console.log('isExpandable');
		if($(this).hasClass('open'))
		{
			if($(this).find('.expandIcon').length > 0){
				$(this).find('.expandIcon').first().html('<i class="fas fa-chevron-up"></i>');
			}else{
				$(this).find('.title').first().append('<span class="expandIcon is-size-4"><i class="fas fa-chevron-up"></i></span>');
			}
		}else if(contentHeight > 150){
			$(this).find('.title').first().append('<span class="expandIcon is-size-4"><i class="fas fa-chevron-down"></i></span>');
		}
		else{
			$(this).find('.expandIcon').remove();
		}
	});
}

function expandContainer(expandable){
	var containerHeight = $(expandable).find('.expandContainer').first().height();
	var contentHeight = $(expandable).find('.expandContent').first().height();
	if(contentHeight > containerHeight){
		$(expandable).find('.expandIcon').first().children().first().removeClass('fa-chevron-down').addClass('fa-chevron-up');
		$(expandable).find('.expandContainer').first().animate({height: contentHeight},800,function(){
			$(expandable).addClass('open');
		});
	}
}

function closeContainer(expandable){
	$(expandable).removeClass('open');
		$(expandable).find('.expandIcon').first().children().first().removeClass('fa-chevron-up').addClass('fa-chevron-down');
		$(expandable).find('.expandContainer').first().animate({height: '150px'},800);
}

function resizeContainer(expandable){
	
	var contentHeight = $(expandable).find('.expandContent').first().height();
	var containerHeight = $(expandable).find('.expandContainer').first().height();
	if(contentHeight > containerHeight || contentHeight > 150){
		//expand
		expandContainer(expandable);
	}
	else{
		//close
		closeContainer(expandable);
	}
}

function clickContainer(expandable){
	if($(expandable).hasClass('open')){
		closeContainer(expandable);
	}
	else{
		expandContainer(expandable);
	}
}

function optionEvents(){
	
	$(document).on("click", '.editField', function(){ editField($(this)); });
	$(document).on("click", '.deleteField', function(){ deleteField($(this)); });
	$(document).on("click", '#saveFarmName', function(evt){ updateFarmName(evt); });
	$(document).on("mouseenter", '#fields .columns', function(){ fieldHover($(this)); });
	$(document).on("mouseleave", '#fields .columns', function(){ fieldUnhover($(this)); });
	$(document).on( "click", ".expandable .title", function(evt){ clickContainer($(this).parent('.expandable')); });
//	$(document).on( "focusout", "#fieldsBox", function(){ collpaseBox($(this)); });
}