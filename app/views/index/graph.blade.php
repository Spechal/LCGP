@extends('layouts.default.graph')

@section('title')
@parent
@stop

@section('content')
@foreach($graphs as $graph)
{{ $graph }}
@endforeach
@stop