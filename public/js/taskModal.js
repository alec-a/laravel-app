class taskModal{
	
	constructor(){
		this.html = '';
		//setup the listners
		var self = this;
		
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
		this.head().buttons().content().foot();
		this.html = this.head+this.buttons+this.content+this.foot;
		$("#modal").append(this.html);
		$('#taskModal').hide().addClass('is-active');
		$('#taskModal').delay(100).fadeIn(300, function(){
				$('#taskModal .delete, #taskModal .modal-background').click(function(){
				$('#taskModal').fadeOut(300, function(){$(this).remove();});
			});
		});
		
		return this;
	}
	
	head(){
		console.log(this.task);
		this.head = `<div class="modal" id="taskModal">
							<div class="modal-background is-light-dim"></div>
							<div class="modal-card has-shadow">
								<header class="modal-card-head has-background-${this.task.bgColour} "><p class="modal-card-title has-text-centered has-text-${this.task.txtColour}"><strong>${this.task.info.task}</strong> On Field: <strong>${this.task.field.info.name}</strong></p><div class="delete"></div></header>
								<section class="modal-card-body">
									<div class="content">`;
		return this;
	}
	
	buttons(){
		this.buttons = `<div class="columns" id="statusButtons">
							<div class="column is-one-quarter">
								<a class="button is-dark ${((this.task.status == 0)? 'is-hovered':'is-outlined')} is-fullwidth">Not Required</a>
							</div>
							<div class="column is-one-quarter">
								<a class="button ${((this.task.status == 1)? 'is-hovered':'is-outlined')} is-info  is-fullwidth">Required</a>
							</div>
							<div class="column is-one-quarter">
								<a class="button is-warning ${((this.task.status == 2)? 'is-hovered':'is-outlined')} is-fullwidth">In Progess</a>
							</div>
							<div class="column is-one-quarter">
								<a class="button is-success ${((this.task.status == 3)? 'is-hovered':'is-outlined')} is-fullwidth">Completed</a>
							</div>
						</div>`;
		return this
	}
	
	content(){
		this.content = `<div id="taskModalContent">`;
							
		if(this.task.status == 3){
			
			
			this.content += `<div class="columns is-marginless" id="completedText">
								<div class="column is-full is-paddingless-top">

										<p class="subtitle has-text-centered">Completed at 11:02 Am on 1 Jan 2019 by Alec Aldous</p>
										<div class='card'>
											<div class="card-content">
												<div class="content is-size-7 has-text-weight-bold">
													Lorem ipsum dolor sit amet, consectetur adipiscing elit.
													Phasellus nec iaculis mauris.
												</div>
											</div>
										</div>
								</div>
							</div>`;
		}
		this.content += `<div class="columns is-multiline" id="note">
							<div class="column is-full is-paddingless-top">
								<div class="is-divider is-half-margin is-marginless-bottom" data-content="Note"></div>
							</div>
						</div>
						<div class="columns is-multiline" id="comments">
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

											<br>
										</div>
									</div>
								</div>
							</div>
						</div>`;
		
		
		
		
		
		
		
		
		this.content += `</div>`;
		return this;
	}
	
	foot(){
		
		this.foot = `</div>
					</section>
				</div>
			</div>`;
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
		return this
	}
}


