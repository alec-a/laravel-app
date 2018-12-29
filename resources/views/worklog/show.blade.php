@php $worklog = $pageData->worklog @endphp
@extends('layouts.userArea')

@section('scripts')
<script src="{{asset('js/farms.js')}}"></script>
@endsection

@section('content')

<h1 class="title is-1">{{empty($worklog->name)? 'Season '.$worklog->season:$worklog->name}}</h1>
{!! empty($worklog->name)? '':'<p class="subtitle">Season '.$worklog->season.'</p>' !!}
<div class="modal is-active">
  <div class="modal-background"></div>
  <div class="modal-card" id="worklogModal">
	  <section class="modal-card-body">
		@foreach($worklog->fields as $field)
			<div class="columns field-row">
				<div class="column field">
					<div class="columns field-head">
						<div class="column has-text-weight-bold">Field</div>
					</div>
					<div class="columns">
						<div class="column has-text-weight-bold">{{$field->info->name}}</div>
					</div>
				</div>
				@foreach($field->tasks as $task)
				
				<div class="column task">
					<div class="columns task-head">
						<div class="column has-text-weight-bold is-size-7">{{ $task->info->task }}</div>
					</div>
					<div class="columns">
						<div class="column">
							<div class="field is-grouped">
								
										<div class="control">
											
												<input type="checkbox"/>
										</div>
									
										<div class="control">
												<input type="checkbox"/>										
										</div>
									
										<div class="control">
											
												<input type="checkbox" />
										</div>
							</div>
						</div>
					</div>
				</div>
				
				@endforeach
				
			</div>
		<hr class="is-marginless has-background-grey-light"/>
		@endforeach
	  </section>
  </div>
</div>
@endsection


