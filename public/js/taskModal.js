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
								<div class="columns is-marginless ${((this.task.status == 3)? 'is-completed-opened':'is-closed')}" id="completed">
									<div class="column is-full is-paddingless-top">

											<p class="subtitle has-text-centered">Completed On <b>${completedDate}</b> At <b>${completedTime}</b> By <b>Alec Aldous</b></p>
											
									</div>
								</div>`;
		
		this.content += `<div class="columns is-multiline ${((this.task.status == 3)? 'is-closed':'')}" id="note">
							<div class="column is-full is-paddingless-top">
								<div class="is-divider is-half-margin is-marginless-bottom" data-content="Note"></div>
							</div>
							<div class="column is-full">
								<textarea class="textarea is-fullwidth" placeholder="${(this.task.note == null)? 'Click to add a note...':''}">${(this.task.note == null)? '':this.task.note}</textarea>
							</div>
						</div>
						<div class="columns is-multiline ${((this.task.status == 3)? 'is-closed':'')}" id="comments">
							<div class="column is-full is-paddingless-top">
								<div class="is-divider is-half-margin is-marginless-bottom" data-content="Comments"></div>
							</div>
							<div class="column is-full">
								<div class="card">
									<div class="card-content">
										<div class="media">
											<div class="media-left">
												<p class="title is-5">John Smith</p>
												<p class="subtitle is-7"><time class=" is-7" datetime="2016-1-1">11:09 PM - 1 Jan 2016</time></p>
											</div>
											<div class="media-content">

											</div>
										</div>
										<div class="content is-size-7 has-text-weight-bold">
											Lorem ipsum dolor sit amet, consectetur adipiscing elit.
											Phasellus nec iaculis mauris.
										</div>
									</div>
								</div>
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
		console.log(this);
		$("#modal").append(this.html);
		$('#taskModal .is-completed').hide();
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
		$('.button').click(function(){
			if($(this).data('wlt-status') != null){
				self.updateStatus($(this));
			}
		});
	
	}
	
	updateStatus(target){
		var status = $(target).data('wltStatus');
		var oldButton = $('#statusButtons .is-hovered').first();
		var oldButtonStatus = $(oldButton).data('wltStatus');
		var self = this;
		
		if(status !== oldButtonStatus){
			$(target).switchClass('is-outlined','is-hovered is-loading',{duration:300,complete:function(){;
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
							console.log(data);
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
								$('#taskModal #completed p').html(`Completed On <b>${completedDate}</b> At <b>${completedTime}</b> By <b>Alec Aldous</b>`);
								$('#taskModal #note,#taskModal #comments').slideUp(300, function(){$(this).addClass('is-closed')}).fadeOut(150);
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
}


