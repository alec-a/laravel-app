@php $worklog = $pageData->worklog @endphp
@extends('layouts.userArea')

@section('scripts')
<script src="{{asset('js/farms.js')}}"></script>
@endsection

@section('content')

<h1 class="title is-1">{{empty($worklog->name)? 'Season '.$worklog->season:$worklog->name}}</h1>
{!! empty($worklog->name)? '':'<p class="subtitle">Season '.$worklog->season.'</p>' !!}
@endsection
