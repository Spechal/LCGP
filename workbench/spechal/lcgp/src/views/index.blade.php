@extends('layouts.main')

@section('title')
@parent
@stop

@section('content')
<div class="row">
    <div class="col-md-4 form-group"><h4>Hosts</h4></div>
    <div class="col-md-4 form-group pull-right"><form class="form-inline"><input type=text" class="form-control" placeholder="search" /><button type="submit" class="btn btn-sm">Submit</button></form></div>
</div>
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
            <td class="@if($host['short'] > $host['cores']) alert-danger @elseif($host['short'] > $host['cores']/2) alert-warning @endif">{{ round($host['short'], 2) }}</td>
            <td class="@if($host['mid'] > $host['cores']) alert-danger @elseif($host['short'] > $host['cores']/2) alert-warning @endif">{{ round($host['mid'], 2) }}</td>
            <td class="@if($host['long'] > $host['cores']) alert-danger @elseif($host['short'] > $host['cores']/2) alert-warning @endif">{{ round($host['long'], 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@stop