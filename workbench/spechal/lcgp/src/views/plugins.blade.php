@extends('lcgp::layouts.graph')

@section('title')
@parent
@stop

@section('content')
<div>
    <ol class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">{{ $host }}</li>
    </ol>
</div>
<div>
    <ul class="nav nav-pills">
    @foreach($plugins as $plugin)
        <li><a href="/collectd/graph/{{ $host }}/{{ $plugin }}">{{ $plugin }}</a></li>
    @endforeach
    </ul>
</div>
<div class="container">
    @foreach($plugins as $plugin)
        <h4>{{ ucfirst($plugin) }} graphs for {{ $host }}</h4>
        @foreach($graphs[$plugin] as $graph)
        {{ $graph }}
        @endforeach
    @endforeach
</div>
@stop