@extends('layouts.main')

@section('title')
@parent
@stop

@section('content')
<h4>Hosts</h4>
<ul>
@foreach($hosts as $host)
    
@endforeach
</ul>
@stop