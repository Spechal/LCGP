@extends('layouts.main')

@section('title')
@parent
@stop

@section('content')
<h4>Hosts</h4>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Host Name</th>
            <th>Short Load</th>
            <th>Mid Load</th>
            <th>Long Load</th>
        </tr>
    </thead>
    <tbody>
    @foreach($hosts as $host)
        <tr>
            <td><a href="/collectd/plugins/{{ $host['name'] }}">{{ $host['name'] }}</a></td>
            <td class="@if($host['short'] > $host['cores']) alert-danger @endif">{{ round($host['short'], 2) }}</td>
            <td class="@if($host['mid'] > $host['cores']) alert-danger @endif">{{ round($host['mid'], 2) }}</td>
            <td class="@if($host['long'] > $host['cores']) alert-danger @endif">{{ round($host['long'], 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@stop