@extends('layouts.userArea')

@section('content')
{{Auth::user()->name}}
{{Auth::user()->email}}

@endSection