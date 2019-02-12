/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).on('click','.modal-background, .modal .delete, .modal .close',function(){
	$(this).parents('.modal').css({opacity:'1'}).animate({opactiy:'0'},{duration:300,complete:function(){
			$(this).remove();
	}});
});

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
	
	$('.navbar-burger').click(function(){
		var target = '#'+$(this).data('target');
		$(this).toggleClass('is-active');
		$(target).toggleClass('is-active');
	});
});

function insertModal(data, textStatus, jqXHR){
	$("#modal").html(data);
}

function getModal(controller, name, extras, callback){

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
		success: function(data){
			callback(data);
		}
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
