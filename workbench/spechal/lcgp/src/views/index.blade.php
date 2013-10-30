@extends('layouts.main')

@section('title')
@parent
@stop

@section('content')
<h4>Hosts</h4>
<ul>
@foreach($hosts as $host)
    <li><a href="/collectd/plugins/{{ $host.name }}">{{ $host.name }}</a></li>
@endforeach
</ul>
@stop