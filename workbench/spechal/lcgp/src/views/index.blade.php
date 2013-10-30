@extends('layouts.main')

@section('title')
@parent
@stop

@section('content')
<h4>Hosts</h4>
<table class="table table-striped">
@foreach($hosts as $host)
    <tr>
        <td><a href="/collectd/plugins/{{ $host['name'] }}">{{ $host['name'] }}</a></td>
        <td>{{ $host['shortterm'] }}</td>
        <td>{{ $host['midterm'] }}</td>
        <td>{{ $host['longterm'] }}</td>
    </tr>
@endforeach
</table>
@stop