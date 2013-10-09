@extends('layouts.default.main')

@section('title')
@parent
@stop

@section('content')
<h4>Hosts</h4>
<ul>
@foreach($hosts as $host)
    <li><a href="/collectd/plugins/{{ $host }}">{{ $host }}</a></li>
@endforeach
</ul>
@stop