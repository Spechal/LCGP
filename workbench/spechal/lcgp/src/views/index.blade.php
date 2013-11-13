@extends('layouts.main')

@section('title')
@parent
@stop

@section('content')
<div class="row">
    <div class="col-md-4 form-group"><h4>Hosts</h4></div>
    <div class="col-md-4 form-group pull-right"><form class="form-inline"><input type=text" class="form-control form-control-75" placeholder="search" id="search-box" /><button type="submit" class="btn btn-sm margin5">Submit</button></form></div>
</div>
<div id="filter-count"></div>
<table class="table table-striped table-bordered" id="searchable">
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
        <tr class="host">
            <td><a href="/collectd/plugins/{{ $host['name'] }}">{{ $host['name'] }}</a></td>
            <td class="@if($host['short'] > $host['cores']) alert-danger @elseif($host['short'] > $host['cores']/2) alert-warning @endif">{{ round($host['short'], 2) }}</td>
            <td class="@if($host['mid'] > $host['cores']) alert-danger @elseif($host['short'] > $host['cores']/2) alert-warning @endif">{{ round($host['mid'], 2) }}</td>
            <td class="@if($host['long'] > $host['cores']) alert-danger @elseif($host['short'] > $host['cores']/2) alert-warning @endif">{{ round($host['long'], 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@stop