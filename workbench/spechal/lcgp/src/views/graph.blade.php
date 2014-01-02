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

<div class="container form-group">
    <form method="post" action="/collectd/graph/{{$host}}/{{$plugin}}">
    <div class="input-group date col-md-4 margin5" id="start">
        <input name="start" type="text" placeholder="{{date('m/d/Y', $start)}}" class="form-control" /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
    </div>
    <div class="input-group date col-md-4 margin5" id="end">
        <input name="end" type="text" placeholder="{{date('m/d/Y', $end)}}" class="form-control" /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
    </div>
    <div class="input-group col-md-2 margin5" id="end">
        <button type="submit" class="btn btn-success form-control" onclick="return checkDates()">Update</button>
    </div>
    </form>
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
{{ HTML::style('packages/spechal/lcgp/css/bootstrap-datetimepicker.min.css', array('media' => 'screen')) }}
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
{{ HTML::script('packages/spechal/lcgp/js/bootstrap-datetimepicker.min.js') }}
<script type="text/javascript">
    <!--
        $(function(){
            $('#start').datetimepicker({startDate: '{{ date('m/d/Y', strtotime('3 months ago')) }}', endDate:'{{ date('m/d/Y') }}'});
            $('#end').datetimepicker({startDate: '{{ date('m/d/Y', strtotime('3 months ago')) }}', endDate:'{{ date('m/d/Y') }}'});
        });

        function checkDates(){
            if($('#start').data('DateTimePicker').getDate() > $('#end').data('DateTimePicker').getDate()){
                alert('Start date is beyond end date');
                return false;
            }
            return true;
        }
    //-->
</script>
@stop

