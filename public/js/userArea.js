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
		
		
		
		//Farms Js
		$("#new").click(function(){
			$('#newModal').addClass('is-active');
			$('#newModal input[name="farmName"]').focus();
			$("#newCreate").click(function(evt){
				evt.stopImmediatePropagation();
				evt.preventDefault();
				console.log('click');
				var inputs = $("#newModal input");
				var formData = [];
				for(var i = 0; i < inputs.length; i++){
					formData[inputs[i].name] = inputs[i].value;
				}
				if(formData['_token'].length > 0 && formData['farmName'].length >0){
					formData['ajax'] = true;
					formData = {...formData};
					$.ajax({
				type: "POST",
				url: "/farms",
				data: formData,
				success: showNewFarm
			});
				}			
			});
			$("#newClose").click(function(){
				$('#newModal input[name="farmName"]').val('');
				$('#newModal').removeClass('is-active');
			});
			
		});
		
		$("#deleteFarm").click(function(){
			var extras = {};
			extras.farmId = $("#farmId input").val();
			getModal('farms','delete',extras);
		});
		
		$("#rename").click(function(){
			var currName = $("#farmName h1").text();
			$("#farmName h1").hide();
			$("#farmName form .input:text").val(currName);
			$("#farmName form").show();
			$("#farmName form .input").focus();
		});
		
		
		$('.dropdown-content').click(function(){
			var dropdown = $(this).parents('.dropdown');
			if(dropdown.hasClass('is-active')){
				dropdown.removeClass('is-active');
			}
		});
		
		$('#cancelRename').click(function(){
			$("#farmName form").hide();
			$("#farmName h1").show();
		});
		
		
		
	});
	
	function showNewFarm(data, textStatus, jqXHR){
		var bottomRow = $('#farms .columns').last();
		if(bottomRow.length > 0){
			var numInRow = $(bottomRow).children('.column').length;
			var lastInRow  = $(bottomRow).children('.column').last();

			if(numInRow == 3){
				$(bottomRow).after('<div class="columns">'+data+'</div>');
			}
			else{
				$(lastInRow).after(data);
			}

			$('#newModal').removeClass('is-active');
			$('#newModal input[name="farmName"]').val('');
		}
		else{
			$("#farms").html('<div class="columns">'+data+'</div>');
			$('#newModal').removeClass('is-active');
			$('#newModal input[name="farmName"]').val('');
		}
		return true;
	}
	
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