@extends('layouts.main')

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

<div class="form-group">
    <div class="input-group date col-md-6" id="start">
        <input type="text" placeholder="Start" class="form-control" /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
    </div>
    <div class="input-group date col-md-6" id="end">
        <input type="text" placeholder="End" class="form-control" /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
    </div>
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

@section('styles')
{{ HTML::style('assets/css/bootstrap-datetimepicker.min.css', array('media' => 'screen')) }}
@stop

@section('scripts')
{{ HTML::script('packages/spechal/lcgp/js/sprintf.js') }}
{{ HTML::script('packages/spechal/lcgp/js/strftime.js') }}
{{ HTML::script('packages/spechal/lcgp/js/RrdRpn.js') }}
{{ HTML::script('packages/spechal/lcgp/js/RrdTime.js') }}
{{ HTML::script('packages/spechal/lcgp/js/RrdGraph.js') }}
{{ HTML::script('packages/spechal/lcgp/js/RrdGfxCanvas.js') }}
{{ HTML::script('packages/spechal/lcgp/js/binaryXHR.js') }}
{{ HTML::script('packages/spechal/lcgp/js/rrdFile.js') }}
{{ HTML::script('packages/spechal/lcgp/js/RrdDataFile.js') }}
{{ HTML::script('packages/spechal/lcgp/js/RrdCmdLine.js') }}
{{ HTML::script('packages/spechal/lcgp/js/CGP.js') }}
{{ HTML::script('assets/js/bootstrap-datetimepicker.min.js') }}
<script type="text/javascript">
    <!--
        $(function(){
            $('#start').datetimepicker();
            $('#end').datetimepicker();
        });
    //-->
</script>
@stop

