@extends('layouts.main')

@section('title')
@parent
@stop

@section('content')
<div class="row">
    <div class="col-md-4 form-group"><h4>Hosts</h4></div>
    <div class="col-md-4 form-group pull-right"><form class="form-inline"><input type=text" class="form-control" placeholder="search" id="search-box" /></form></div>
</div>
<div id="filter-count"></div>

@if(count($groups))
<div>
    <ul class="nav nav-pills">
        @foreach($groups as $name => $group)
        <li><a href="#{{ $name }}">{{ $name }}</a></li>
        @endforeach
    </ul>
</div>
@endif

<div id="searchable">

@if(count($groups))
@foreach($groups as $name => $group)
<h4><a id="{{ $name }}">{{ $name }}</a></h4>
<table class="table table-striped table-bordered">
    <thead>
    <tr id="host-header">
        <th>Host Name</th>
        <th>Short Load</th>
        <th>Mid Load</th>
        <th>Long Load</th>
    </tr>
    </thead>
    <tbody>
    @foreach($group as $host)
    <tr class="host">
        <td><a href="/collectd/plugins/{{ $host['name'] }}">{{ $host['name'] }}</a></td>
        <td class="@if($host['short'] > $host['cores']) alert-danger-custom @elseif($host['short'] > $host['cores']/2) alert-warning-custom @endif">{{ round($host['short'], 2) }}</td>
        <td class="@if($host['mid'] > $host['cores']) alert-danger-custom @elseif($host['short'] > $host['cores']/2) alert-warning-custom @endif">{{ round($host['mid'], 2) }}</td>
        <td class="@if($host['long'] > $host['cores']) alert-danger-custom @elseif($host['short'] > $host['cores']/2) alert-warning-custom @endif">{{ round($host['long'], 2) }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@endforeach
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr id="host-header">
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
        <td class="@if($host['short'] > $host['cores']) alert-danger-custom @elseif($host['short'] > $host['cores']/2) alert-warning-custom @endif">{{ round($host['short'], 2) }}</td>
        <td class="@if($host['mid'] > $host['cores']) alert-danger-custom @elseif($host['short'] > $host['cores']/2) alert-warning-custom @endif">{{ round($host['mid'], 2) }}</td>
        <td class="@if($host['long'] > $host['cores']) alert-danger-custom @elseif($host['short'] > $host['cores']/2) alert-warning-custom @endif">{{ round($host['long'], 2) }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

</div>

@stop
