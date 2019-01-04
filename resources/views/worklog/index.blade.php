@php extract((array)$pageData) @endphp
@extends('layouts.userArea')

@section('scripts')
<script src="{{asset('js/farms.js')}}"></script>
@endsection

@section('content')
<h1 class="title is-1">Worklogs</h1>
<p class="subtitle">{{$farm->name}}</p>
<div class="tabs is-boxed">
  <ul>
    <li class="is-active">
      <a>
        <span>Worklogs</span>
      </a>
    </li>
    <li>
      <a>
       
        <span>Deleted Worklogs</span>
      </a>
    </li>
  </ul>
</div>
<div class="columns is-multiline is-mobile" id="worklogs">
	@if($farm->worklogs->count() > 0)
		@foreach($farm->worklogs as $worklog)
		
			<div class="column is-one-third">
				<a href="{{url('/farm/'.$worklog->farm->id.'/worklog/'.$worklog->id)}}">
				<div class="card has-text-centered">
					<header class="card-header">
						<p class="card-header-title">{{empty($worklog->name)? 'season '.$worklog->season : $worklog->name}}</p>
					</header>
					
					{!! empty($worklog->name)? '' : '<div class="card-content"><div class="content"><p class="subtitle">season '.$worklog->season.'</p></div></div>' !!}
					<div class="card-footer">
						<a href="#" class="card-footer-item">Re Name</a>
						<a href="#" class="card-footer-item has-text-danger">Delete</a>
					</div>
				</div>
				</a>
			</div>
		
		@endforeach
	
	@else
		
	<div class="column"><p class="subtitle has-text-centered">No Worklogs on this farm</p></div>
	@endif
</div>
<div class="columns is-multiline is-mobile">
	
</div>
@endsection
