$(document).ready(function(){
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
		if($('#fieldsNotification').length > 0){
			
			if($('#worklogNotification').length > 0){
				$('#worklogNotification').fadeOut(500, function (){ $('#worklogs').fadeIn(500); });
			}
			$('#fieldsNotification').fadeOut(500, function(){
				$('#fields').append(data.response);
			});

		}
		else{
			if($('#worklogNotification').length > 0){
				$('#worklogNotification').fadeOut(500, function (){ $('#worklogs').fadeIn(500); });
			}
			$('#fields').append(data.response);
		}
		$('#newFieldForm input[name="name"]').val('');
		$('#newFieldForm select').val('Crop');
		$('#newFieldForm select').first('option').attr('selected');
	}
	else
	{
		//erros
		
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

function optionEvents(){
	
	$(document).on("click", '.editField', function(){ editField($(this)); });
	$(document).on("click", '.deleteField', function(){ deleteField($(this)); });
	$(document).on("click", '#saveFarmName', function(evt){ updateFarmName(evt); });
	$(document).on("mouseenter", '#fields .columns', function(){ fieldHover($(this)); });
	$(document).on("mouseleave", '#fields .columns', function(){ fieldUnhover($(this)); });
}