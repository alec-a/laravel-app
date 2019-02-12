class taskModal{
	
	constructor(){
		this.html = '';
		
	}
	
	getData(taskId){
		
		var self = this;
		var ajax_url = '/ajax'+window.location.pathname;
		
		var formData = {
			_token:$('#token input').val(),
			task_id:taskId
		};
		var serverReturn = $.ajax({
			type:'post',
			url:ajax_url,
			data:formData,
			success: function(data){return self.build(data);}
		});
		return this;
	}
	
	build(data){
		this.data = JSON.parse(data);
		this.task = this.data.response.worklogTask;
		this.crops = this.data.response.crops;
		var self = this;
		
		this.head().buttons().content().foot(function(){ self.show(); });
		return this;
	}
	
	head(){
		
		this.head = `<div class="modal" id="taskModal">
							<div class="modal-background is-light-dim"></div>
							<div class="modal-card has-shadow">
								<header class="modal-card-head has-background-${this.task.bgColour} "><p class="modal-card-title has-text-centered has-text-${this.task.txtColour}"><b>${this.task.info.task}</b> On Field: <b>${this.task.field.info.name}</b></p><div class="delete"></div></header>
								<section class="modal-card-body">
									<div class="content">`;
		
		return this;
	}
	
	buttons(){
		this.buttons = `<div class="columns" id="statusButtons">
							<div class="column is-one-quarter">
								<a class="button is-dark ${((this.task.status == 0)? 'is-hovered':'is-outlined')} is-fullwidth" data-wlt-status="0">Not Required</a>
							</div>
							<div class="column is-one-quarter">
								<a class="button ${((this.task.status == 1)? 'is-hovered':'is-outlined')} is-info  is-fullwidth" data-wlt-status="1">Required</a>
							</div>
							<div class="column is-one-quarter">
								<a class="button is-warning ${((this.task.status == 2)? 'is-hovered':'is-outlined')} is-fullwidth" data-wlt-status="2">In Progess</a>
							</div>
							<div class="column is-one-quarter">
								<a class="button is-success ${((this.task.status == 3)? 'is-hovered':'is-outlined')} is-fullwidth" data-wlt-status="3">Completed</a>
							</div>
						</div>`;
		return this;
	}
	
	content(){
		
		this.content = `<div id="taskModalContent">`;
			
			var date = new Date(this.task.completed_on);
			var completedDate = new Intl.DateTimeFormat('en-GB', { year: 'numeric', month: '2-digit', day: '2-digit'}).format(date);
			completedDate = completedDate.replace(/\//g,'-');
			var completedTime = new Intl.DateTimeFormat('en-GB', { hour: '2-digit', minute: '2-digit'}).format(date);
			
			this.content += `
								<div class="columns is-marginless ${((this.task.status == 3)? 'is-completed-opened':'is-completed-closed')}" id="completed">
									<div class="column is-full is-paddingless-top">

											<p class="subtitle has-text-centered">Completed On <b>${completedDate}</b> At <b>${completedTime}</b> By <b>${(this.task.completed_user)? this.task.completed_user.name:''}</b></p>
											
									</div>
								</div>`;
		if(this.task.task_id == 6){
			this.content += `<div class="columns is-multiline ${((this.task.status == 3)? 'is-closed':'')}" id="crop">
							<div class="column is-half is-paddingless-top">
								<div class="is-divider is-half-margin is-marginless-bottom" data-content="Crop"></div>
							</div>
							<div class="column is-half is-paddingless-top">
								<div class="is-divider is-half-margin is-marginless-bottom" data-content="Planted With Fertilizer"></div>
							</div>
							<div class="column is-half">
								<div class="select is-fullwidth">
									<select>${this.cropOptions()}</select>
								</div>
							</div>
							<div class="column is-half has-text-centered">
								<p class='is-size-7'><span id="fertilizer" class="fa-stack fa-lg">
									<i class="far fa-square fa-stack-2x"></i>
									<i class="fas fa-check fa-ban fa-stack-1x has-text-success ${(this.task.task_option == 1)? '':'is-invisible'}"></i>

								</span></p>
							</div>
						</div>`;
		}
		this.content += `<div class="columns is-multiline ${((this.task.status == 3)? 'is-closed':'')}" id="note">
							<div class="column is-full is-paddingless-top">
								<div class="is-divider is-half-margin is-marginless-bottom" data-content="Note"></div>
							</div>
							<div class="column is-full">
								<textarea id="noteText" class="textarea is-fullwidth" placeholder="${(this.task.note == null)? 'Click to add a note...':''}">${(this.task.note == null)? '':this.task.note}</textarea>
							</div>
						</div>`;
		this.content += '</div>';
		return this;
	}
	foot(callback){
		
		this.foot = `</div>
					</section>
				</div>
			</div>`;
		callback();
		return this;
		
	}
	
	comments(generateHtml=false){
		if(this.task.comments != null){
			this.comments[0] = `<div class="columns is-multiline" id="comments">`;
			
			for(var i = 0; i < this.task.comments.length; i++){
				var comment = this.task.comments[i];
				var cindex = (generateHtml)? i+1:i;
				this.comments[cindex] = ``;
			}
			
			if(generateHtml){this.comments.push('</div>');}
		}
		
		
		if(generateHtml){
			
		}
		return this;
	}
	
	show(){
		//console.log(this);
		var self = this;
		this.html = this.head;
		this.html += this.buttons;
		this.html+=this.content;
		this.html+=this.foot;
		$("#modal").append(this.html);
		$('#taskModal .is-completed-closed').hide();
		$('#taskModal .is-closed').hide();
		$('#taskModal').hide().addClass('is-active');
		$('#taskModal').delay(100).fadeIn(300, function(){
				self.addListners();
				$('#taskModal .delete, #taskModal .modal-background').click(function(){
				$('#taskModal').fadeOut(300, function(){$(this).remove();});
			});
		});
		
	}
	
	addListners(){
		var self = this;
		$('#statusButtons .button').click(function(){
			if($(this).data('wlt-status') != null){
				self.updateStatus($(this));
			}
		});
		
		$('#crop select').change(function(){
			self.updateCrop($(this));
		});
		$('#crop #fertilizer').click(function(){
			self.updateOption($(this));
		});
		
		$("#noteText").focusin(function(){
			self.oldNoteText = $(this).val();
			return self;
		});
		$("#noteText").focusout(function(){
			self.updateNote();		
		});
		
	}
	
	updateStatus(target){
		var status = $(target).data('wltStatus');
		var oldButton = $('#statusButtons .is-hovered').first();
		var oldButtonStatus = $(oldButton).data('wltStatus');
		var self = this;
		
		if(status !== oldButtonStatus){
			$(target).switchClass('is-outlined','is-hovered is-loading',{duration:300,complete:function(){
					var formData = {
						'_token':$("#token input").val(),
						'_method':'put',
						'taskStatus':status
					};
					$.ajax({
						type:'post',
						url:'/ajax/farm/'+self.task.worklog.farm_id+'/task/'+self.task.id,
						data:formData,
						success: function(data){
							data = JSON.parse(data);
							var oldClass = 'has-background-'+self.task.bgColour;
							var oldtxtClass = 'has-text-'+self.task.txtColour;
							var newClass = 'has-background-'+data.bgColour;
							var newtxtClass = 'has-text-'+data.txtColour;
							$(oldButton).switchClass('is-hovered','is-outlined',500);
							$(target).switchClass('is-loading','',300);
							$("#taskModal header p").switchClass(oldtxtClass, newtxtClass,300);
							$('#taskModal header').switchClass(oldClass,newClass,300);
							$('.wltask[data-wlt="'+data.id+'"]').switchClass(oldtxtClass, newtxtClass,300);
							$('.wltask[data-wlt="'+data.id+'"]').switchClass(oldClass,newClass,{duration:300,complete:function(){
									return self.task = data;
							}});
						
							//if the user has completed the task show it in the modal
							if(data.completed_by_id != null)
							{
								
								var date = new Date(data.completed_on);
								var completedDate = new Intl.DateTimeFormat('en-GB', { year: 'numeric', month: '2-digit', day: '2-digit'}).format(date);
								completedDate = completedDate.replace(/\//g,'-');
								var completedTime = new Intl.DateTimeFormat('en-GB', { hour: '2-digit', minute: '2-digit'}).format(date);
								$('#taskModal #completed p').html(`Completed On <b>${completedDate}</b> At <b>${completedTime}</b> By <b>${data.completed_user.name}</b>`);
								$('#taskModal #note,#taskModal #comments, #taskModal #crop').slideUp(300, function(){$(this).addClass('is-closed')}).fadeOut(150);
								$('#taskModal #completed').slideDown(300, function(){$(this).addClass('is-completed').removeClass('is-closed');}).fadeIn(150);
								
							}
							else{
								$('#taskModal .is-completed, #taskModal .is-completed-opened').slideUp(300, function(){
									$(this).addClass('is-closed').removeClass('is-completed');
								}).fadeOut(150);
								$('#taskModal .is-closed').slideDown(300).fadeIn(150);
							}
							
						}
					});
			}});
		}
		return self;
	}
	
	updateCrop(select){
		var self = this;
		var selected = $(select).val();
		var selectText = $(select).find("option:selected").text();
		var formData = {
			'_token':$("#token input").val(),
			'_method':'put',
			'cropId': parseInt(selected)
		};
		
		
		$.ajax({
			type:'post',
			url:'/ajax/farm/'+this.task.worklog.farm_id+'/task/'+this.task.id,
			data:formData,
			success:function(){
				$('.wltask[data-wlt="'+self.task.id+'"] .cropType').text(selectText);
			}
		});
		
	}
	
	updateOption(fertilizer){
		var self = this;
		
		var option = ($(fertilizer).find('.fa-check').hasClass('is-invisible'))? 1:0;
		
		var formData = {
			'_token':$("#token input").val(),
			'_method':'put',
			'option': option
		};
		
		
		$.ajax({
			type:'post',
			url:'/ajax/farm/'+this.task.worklog.farm_id+'/task/'+this.task.id,
			data:formData,
			success:function(){
				if(option == 1){
					$(fertilizer).find('.fa-check').fadeIn(200,function(){
						$(this).removeClass('is-invisible');
					});
				}
				else
				{
					$(fertilizer).find('.fa-check').fadeOut(200,function(){
						$(this).addClass('is-invisible');
					});
				}
			}
		});
		
	}
	
	updateNote(){
		var self = this;
		var newNoteText = $("#noteText").val();
		
		
		
		if(newNoteText != self.oldNoteText){
			newNoteText = (newNoteText.length > 0)? newNoteText:null;
			var formData = {
				'_token':$("#token input").val(),
				'_method':'put',
				'updateNote':true,
				'note': newNoteText
			};
			$.ajax({
				type:'post',
				url:'/ajax/farm/'+this.task.worklog.farm_id+'/task/'+this.task.id,
				data:formData,
				success:function(){
					$("#noteText").switchClass('','is-success',{duration: 800, complete:function(){
							$("#noteText").switchClass('is-success','',{duration: 800});
					}});
					if(newNoteText != null){
						$('.wltask[data-wlt="'+self.task.id+'"] #noteIcon').switchClass('is-invisible', '',200);
					}
					else
					{
						$('.wltask[data-wlt="'+self.task.id+'"] #noteIcon').switchClass('', 'is-invisible',200);
					}
				}
			});
		}
	}
	
	cropOptions(){
		var options = '';
		var task_option = (this.task.task_option)? JSON.parse(this.task.task_option):null;
		for(var i = 0;i < this.crops.length; i++)
		{
			
			var selected = (this.task.field.crop_id == this.crops[i].id)? 'selected':'';
			options += '<option value="'+this.crops[i].id+'" '+selected+'>'+this.crops[i].name+'</option>';
		}
		return options;
	}
}


