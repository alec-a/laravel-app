@extends('layouts.site')

@section('content')
<div class="content-cell is-capitalized">
	@if ($pageData->page->uri != '/')<h1 class="title is-3">{{$pageData->page->title}}</h1>@endif
	{!! html_entity_decode($pageData->page->content) !!}
</div>
@endsection