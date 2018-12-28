@extends('layouts.userArea')

@section('content')
<div class="columns">
	<div class="column is-two-thirds top">
		<div class="box">
			<h3 class="title is-3 has-text-centered">Edit Issue</h3>
			<form method="post" action="{{url('/issue/'.$pageData->issue->id)}}">
				@csrf
				@method('put');
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label" for="title">Title</label>
					</div>
					<div class="field-body">
						<div class="field">
						  <p class="control is-expanded">
							  <input type="text" name="title" class="input" value="{{$pageData->issue->title}}"/>							  
						  </p>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label" for="content">Description</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								 <textarea class="textarea" name="content">{{$pageData->issue->content}}</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						
					</div>
					<div class="field-body">
						<div class="field is-grouped is-grouped-centered">
							<div class="control">
								<button type="submit" class="button is-primary is-medium">Save</button>
							</div>
							<div class="control">
								<a href="{{url('/dashboard')}}" class="button is-light is-medium">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
</div>
@endsection
