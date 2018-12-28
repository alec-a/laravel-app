@extends('layouts.userArea')

@section('content')
<div class="columns">
	<div class="column is-two-thirds">
		<div class="box">
			@foreach($pageData->versions as $version)
			<div class="content version">
			<h4 class="title is-4 {{$version->active? 'has-text-success':'has-text-info'}}">Version {{$version->name}}</h4>
				@if ($version->issues->count() > 0)
					@foreach($version->issues as $issue)
					<div class="card issue">
						<header class="card-header">
													
							<p class="card-header-title {{$issue->open? '':'is-strike'}}">
							  {{$issue->title}}
							</p>
							
						</header>
						<div class="card-content">
						  
							<div class="media">
								<div class="media-left">
								  @if($issue->open)
								  <p class="subtitle has-text-danger has-text-weight-bold">Open</p>
								  @else
								   <p class="subtitle has-text-primary has-text-weight-bold">Closed</p>
								  @endif
								</div>
								<div class="media-content">
									<div class="content {{$issue->open? '':'is-strike'}}">
										{{$issue->content}}
										
									</div>
									<div clas="content">
										<p class="is-size-7">Opened On <strong><time datetime="{{$issue->created_at}}">{{$issue->created_at->format('d-m-Y @ H:i')}}</time></strong> By <strong>{{$issue->author->name}}</strong></p>
										@if(!$issue->open)
										<p class="is-size-7">Closed On <strong><time datetime="{{$issue->closed_at}}">{{$issue->closed_at->format('d-m-Y @ H:i')}}</time></strong> By <strong>{{$issue->closedBy->name}}</strong></p>
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
								<input type="hidden" name='re_open' value="true"/>
								<a class="card-footer-item" onclick="$('#reOpen_{{$issue->id}}').submit();">Re-Open</a>
							</form>	
							@elseif ($issue->open || $issue->re_open)
							<form method="post" action="{{url('/issue/'.$issue->id)}}" class="card-footer-item" id="close_{{$issue->id}}">
								@csrf()
								@method('put')
								<input type="hidden" name='close' value="true"/>
								<a class="card-footer-item" onclick="$('#close_{{$issue->id}}').submit();">Close</a>
							</form>	
							@endif
							@if (auth()->user()->role == 1)
							<form method="post" action="{{url('/issue/'.$issue->id)}}" class="card-footer-item" id="close_{{$issue->id}}">
								@csrf()
								@method('delete')
								<input type="hidden" name='close' value="true"/>
								<a class="card-footer-item"  onclick="$('#close_{{$issue->id}}').submit();">Delete</a>
							</form>	
							@endif
						  </footer>
						@endif
					  </div>
					@endforeach
				@endif
			</div>
			@if ($loop->count > 1 && !$loop->last)
			<hr/>
			@endif
			@endforeach
		</div>
	</div>
	<div class="column is-one-third" id="newIssueContainer">
		<div class="box is-pinned">
			<a href="/issue/create" class="button is-primary is-fullwidth is-large"><strong>Report A New Issue</strong></a>
		</div>
	</div>
</div>

<scirpt></scirpt>
@endsection
