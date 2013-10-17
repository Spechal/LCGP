@extends('lcgp::layouts.graph')

@section('title')
@parent
@stop

@section('content')
<div>
    <ol class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/collectd/plugins/{{ $host }}">{{ $host }}</a></li>
        <li class="active">{{ $plugin }}</li>
    </ol>
</div>
<div>
    <ul class="nav nav-pills">
        @foreach($plugins as $plug)
        <li @if($plug == $plugin) class="active"@endif><a href="/collectd/graph/{{ $host }}/{{ $plug }}">{{ $plug }}</a></li>
        @endforeach
    </ul>
</div>
<div class="container">
    <h4>{{ ucfirst($plugin) }} graphs for {{ $host }}</h4>
    @foreach($graphs[$plugin] as $graph)
    {{ $graph }}
    @endforeach
</div>
@stop