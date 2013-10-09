@extends('layouts.default.main')

@section('title')
@parent
@stop

@section('content')
<h4>Plugins for {{ $host }}</h4>
<ul>
@foreach($plugins as $plugin)
    <li><a href="/graph/{{ $host }}/{{ $plugin }}">{{ $plugin }}</a></li>
@endforeach
</ul>
@stop