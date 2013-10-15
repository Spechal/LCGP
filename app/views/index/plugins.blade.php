@extends('layouts.default.main')

@section('title')
@parent
@stop

@section('content')
<a href="/">Home</a>
<h4>Plugins for {{ $host }}</h4>
<ul>
@foreach($plugins as $plugin)
    <li><a href="/collectd/graph/{{ $host }}/{{ $plugin }}">{{ $plugin }}</a></li>
@endforeach
</ul>
@stop