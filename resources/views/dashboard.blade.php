@extends('layouts.userArea')

@section('content')
<script>
function closeIssue(issueForm){
	$("#closeIssue").addClass('is-active');
	$("#modalOk").click(function(evt, issueFom){
		$(issueForm).find('#close_comment').first().val($("#modalComment").val());
		$(issueForm).submit();
	});
}
</script>
<div class="modal" id="closeIssue">
	<div class="modal-background"></div>
	<div class="modal-card">
		 <section class="modal-card-body">
			 <div class="field">
				 <label class="label">Comment</label>
				 <div class="control">
					 <textarea id="modalComment" class='textarea'></textarea>
				 </div>
			 </div>
			 <div class="field is-grouped is-grouped-centered">
				 <div class="control">
					 <button id="modalOk" class='button is-success is-large'>Ok</button>
				 </div>
			 </div>
		</section>
	</div>
</div>
<div class="columns">
	<div class="column">
		<h1 class="title is-1">Dashboard</h1>
		<div class="box">
			<h3 class="title is-3 has-text-centered">Versions</h3>
			
			<hr/>
			@foreach($pageData->versions as $version)
			<div class="content version">
			<h4 class="title is-size-4 {{$version->active? 'has-text-success':'has-text-info'}} has-text-centered">{{$version->name}}</h4>
			@if($version->changelog)
			<div style="white-space: pre-wrap;"><p class="has-text-centered is-size-4"><b>Changelog:</b></p>{!! $version->changelog !!}</div>
			 @endif
			
				@if ($version->issues->count() > 0)
				<p class="subtitle has-text-centered is-size-4">{{$version->issues->count()}} Issue{{($version->issues->count() == 1) ? '':'s'}}</p>
					@foreach($version->issues as $issue)
					<div class="card issue">
						<header class="card-header">
													
							<p class="card-header-title {{$issue->open? '':'is-strike'}}">
							  {{$issue->title}}
							</p>
							
						</header>
						<div class="card-content">
						  
							<div class="media">
								<div class="media-left" id="issueTags">
								  @if($issue->open && !$issue->re_open)
								  <p class="button is-medium is-active is-warning has-text-weight-bold has-default-cursor is-radiusless is-fullwidth">Open</p>
								  @elseif($issue->re_open)
								  <p class="button is-medium is-active is-danger has-text-weight-bold has-default-cursor is-radiusless is-fullwidth">Re Opened</p>
								  @else
								   <p class="button is-medium is-active is-success has-text-weight-bold has-default-cursor is-radiusless is-fullwidth">Closed</p>
								  @endif
								</div>
								<div class="media-content">
									<div class="content {{$issue->open? '':'is-strike'}}">
										{{$issue->content}}
										
									</div>
									<div clas="content">
										<p class="is-size-7">Opened On <strong><time datetime="{{$issue->created_at}}">{{$issue->created_at->format('d-m-Y @ H:i')}}</time></strong> By <strong>{{$issue->author->name}}</strong></p>
										@if(!$issue->open)
										<p class="is-size-7">Closed On <strong><time datetime="{{$issue->closed_at}}">{{$issue->closed_at->format('d-m-Y @ H:i')}}</time></strong> By <strong>{{$issue->closedBy->name}}</strong> {!! empty($issue->close_comment)? '':' With Comment:<br/><strong>'.$issue->close_comment.'</strong>' !!}</p>
										
										@endif
										@if($issue->re_open)
										<p class="is-size-7">Re-Opened On <strong><time datetime="{{$issue->re_opened_at}}">{{$issue->re_opened_at->format('d-m-Y @ H:i')}}</time></strong> By <strong>{{$issue->reOpenedBy->name}}</strong></p>
										@endif
									</div>
								</div>
							</div>
						</div>
						@if(auth()->user()->id == $issue->user_id || auth()->user()->role == 1)
						<footer class="card-footer">
							<a href="{{url('/issue/'.$issue->id.'/edit')}}" class="card-footer-item">Edit</a>							
							@if(!$issue->open)
							<form method="post" action="{{url('/issue/'.$issue->id)}}" class="card-footer-item" id="reOpen_{{$issue->id}}">
								@csrf()
								@method('put')
								<input type="hidden" name='re_openIssue' value="true"/>
								<a class="card-footer-item" onclick="$('#reOpen_{{$issue->id}}').submit();">Re-Open</a>
							</form>	
							@elseif ($issue->open || $issue->re_open)
							<form method="post" action="{{url('/issue/'.$issue->id)}}" class="card-footer-item" id="close_{{$issue->id}}">
								@csrf()
								@method('put')
								<input type="hidden" name='closeIssue' value="true"/>
								<textarea id="close_comment" name="close_comment" class="hidden"></textarea>
								<a class="card-footer-item" onclick="closeIssue($('#close_{{$issue->id}}'))">Close</a>
							</form>	
							@endif
							@if (auth()->user()->role == 1)
							<form method="post" action="{{url('/issue/'.$issue->id)}}" class="card-footer-item" id="delete_{{$issue->id}}">
								@csrf()
								@method('delete')
								<input type="hidden" name='deleteIssue' value="true"/>
								<a class="card-footer-item"  onclick="$('#delete_{{$issue->id}}').submit();">Delete</a>
							</form>	
							@endif
						  </footer>
						@endif
					  </div>
					@endforeach
				@else
				<h4 class="title is-4 has-text-centered has-text-grey-light">No Reported Issues</h4>
				@endif
			</div>
			@if(!$loop->last && $loop->count > 1)
			<hr/>
			@endif
			@endforeach
		</div>
	</div>
	
</div>

<scirpt></scirpt>
@endsection
