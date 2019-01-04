/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
		
	$('.subMenu').parent('li').hover(function(){
		$(this).children('ul').slideToggle();
	});

	$('.dropdown-trigger .button').click(function(){
		var dropdown = $(this).parents('.dropdown');
		if(dropdown.hasClass('is-active')){
			dropdown.removeClass('is-active');
		}
		else{
			dropdown.addClass('is-active');
		}
	});
	
	$('.dropdown-content').click(function(){
		var dropdown = $(this).parents('.dropdown');
		if(dropdown.hasClass('is-active')){
			dropdown.removeClass('is-active');
		}
	});
	$('.message').delay(1500).fadeOut(400,function(){$(this).remove();});
	
	$('#farmContentContainer .tabs li a').click(function(){
		var target = $(this).data('tab');
		if($('#farmContentContainer .content[data-tab="'+target+'"]').hasClass('is-active')){
			
		}
		else{
		
			$('#farmContentContainer .tabs .is-active').switchClass('is-active','');
			$(this).parent().switchClass('','is-active');
			$('#farmContentContainer .content.is-active').slideUp(300, function(){
				$(this).removeClass('is-active');
				$('#'+target).slideDown(300, function(){
					$(this).addClass('is-active');
				}).fadeIn(300);
			}).fadeOut(300);
		}
	});
});

function insertModal(data, textStatus, jqXHR){
	$("#modal").html(data);
}

function getModal(controller, name, extras=null){
$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	var formData = [];



	formData['_token'] = $("#token input").val();
	formData['controller'] = controller;
	formData['name'] = name;
	for(var key in extras){
		formData[key] = extras[key];
	}

	formData = {...formData};

	$.ajax({
		type: "POST",
		url: "/ajax/modal/"+controller,
		data: formData,
		success: insertModal
	});
}

function getFormData(form,extras=[]){
	var data = $(form).serializeArray();
	
	for(var i = 0; i < extras.length; i++){
		data.push(extras[i]);
	}
	data.push({name:'ajax',value:true});
	return data;
}