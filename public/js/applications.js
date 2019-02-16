
var tabs = ['new','trial','declined'];



$(document).ready(function(){
	$(document).on('click','.applicant td:not(.selector)',function(evt){
		evt.stopImmediatePropagation();
		evt.preventDefault();
		showApplicant($(this).parent());
	});
	
	$(document).on('click','#statusButtons .button',function(evt){
		evt.stopImmediatePropagation();
		evt.preventDefault();
		changeStatus(this);
	});
	
	if(window.location.hash){
		var target = window.location.hash.substring(1);
		if(tabs.indexOf(target) > -1 && !$('#applicationsContentContainer .content[data-tab="'+target+'"]').hasClass('is-active')){
			$('#applicationsContentContainer #applicationsTabs li.is-active').switchClass('is-active','',1);
			$('#applicationsContentContainer #applicationsTabs li a[data-tab="'+target+'"]').parent().addClass('is-active');
			$('#applicationsContentContainer .main-tab-content.is-active').switchClass('is-active','').hide();
			$('#applicationsContentContainer .main-tab-content[data-tab="'+target+'"]').switchClass('', 'is-active',1).show();
		}
	}
	
	
	$('#applicationsContentContainer #applicationsTabs li a').click(function(){
		var target = $(this).data('tab');
		updateTables(this);
		if(!$('#applicationsContentContainer .main-tab-content[data-tab="'+target+'"]').hasClass('is-active')){
		
			$('#applicationsContentContainer #applicationsTabs .is-active').switchClass('is-active','');
			$(this).parent().switchClass('','is-active');
			$('#applicationsContentContainer .main-tab-content.is-active').slideUp(300, function(){
				$(this).removeClass('is-active');
				$('#applicationsContentContainer .main-tab-content[data-tab="'+target+'"]').slideDown(300, function(){
					$(this).addClass('is-active');
				}).fadeIn(300);
			}).fadeOut(300);
		}
	});
});


function showApplicant(row){
	var applicantId = $(row).data('applicationId');
	
	getModal('applications','showApplicant',{'id':applicantId},function(html){
			var modalDiv = $('<div></div>').css({opacity:0}).addClass('modal');
			$(modalDiv).html(html);
			$("#modal").append($(modalDiv));
			(modalDiv).css({opacity:'0'}).addClass('is-active').animate({opacity:'1'},{duration: 200});
		}
	);
}

function changeStatus(button){
	var statusChange = $(button).data('status');
	var applicantId = $('#applicantModal').data('id');
	
	if(!$(button).hasClass('is-hovered')){
		$('#statusButtons .is-hovered').switchClass('is-hovered','is-outlined');
		$(button).switchClass('is-outlined','is-hovered');
		$(button).addClass('is-loading');
		var formData = {
			_token:$("#data").data('token'),
			_method:'put',
			'changeStatus':statusChange
		};

		$.ajax({
			type:'post',
			url:'/ajax/application/'+applicantId,
			data: formData,
			success: function(data){
				//remove the user from current section
				$(button).removeClass('is-loading');
				$('.applicant[data-application-id="'+applicantId+'"]').fadeOut(300,function(){$(this).remove();});
				$('.modal').css({opacity:'1'}).animate({opactiy:'0'},{duration:300,complete:function(){
						$(this).remove();
				}});
			}
		});
	}
	
}

function updateTables(tab){
	var targetContent = $(tab).data('tab');
	var statusGrop = $(tab).data('statusGroup');
	var formData = {
		_token:$("#data").data('token'),
		'application_status':statusGrop
	}
	$.ajax({
		type:'post',
		url:'/ajax/applications/',
		data: formData,
		success: function(data){
			data = JSON.parse(data);
			var applications = data.applications;
			var countries = data.data.countries;
			var tablehtml = '';
			
			for(i = 0; i < applications.length; i++){
				var application = applications[i];
				var countryCode = application.country;
				tablehtml += '<tr class="applicant" data-application-id="'+application.id+'">';
				
				if(statusGrop == 2){
					tablehtml += '<td class="selector"><input type="checkbox" class="checkbox"></td>';
				}
				
				tablehtml += '<td>'+application.name+'</td>';
				tablehtml += '<td>'+application.email+'</td>';
				tablehtml += '<td>'+application.fsUk+'</td>';
				tablehtml += '<td>'+application.age+'</td>';
				tablehtml += '<td>'+application.realCountry+'</td>';
				
				tablehtml += '</tr>';
				
			}
			
			$('.main-tab-content[data-tab="'+targetContent+'"] .table tbody').html(tablehtml);
		}
	});
}