@extends('layouts.userArea')

@section('scripts')
<script src="{{asset('js/farms.js')}}"></script>
@endsection

@section('content')
<h1 class="title is-1">Worklogs</h1>
<p class="subtitle">{{$pageData->farm->name}}</p>
<article class="notification is-warning">
	This is still under development and may be broken but it's here to look at!
</article>
	@if($pageData->farm->worklogs->count() > 0)
	<div class="columns is-multiline is-mobile">
		@foreach($pageData->farm->worklogs as $worklog)
		
			<div class="column is-one-third">
				<a href="{{url('/farm/'.$worklog->farm->id.'/worklog/'.$worklog->id)}}">
				<div class="box has-text-centered">
						<h3 class="title is-3">{{empty($worklog->name)? 'season '.$worklog->season : $worklog->name}}</h3>
						{!! empty($worklog->name)? '' : '<p class="subtitle">season '.$worklog->season.'</p>' !!}
				</div>
				</a>
			</div>
		
		@endforeach
	</div>
	@else
		
		<p class="subtitle">No Worklogs on this farm</p>
	@endif
@endsection
