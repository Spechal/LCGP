<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @section('title')Content Management Framework
        @show
    </title>

    {{ HTML::style('assets/css/bootstrap-flatly.min.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/css/custom.css', array('media' => 'screen')) }}

</head>
<body>

<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">a
        <div class="navbar-header">
            <a href="/" class="navbar-brand">Content Management Framework</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
    </div>
</div>

<div class="container" id="content">
    @yield('content')
</div>


{{ HTML::script('assets/js/jquery-2.0.3.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}

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

</body>
</html>