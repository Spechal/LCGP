<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @section('title')Content Management Framework
        @show
    </title>

    {{ HTML::style('packages/spechal/lcgp/css/bootstrap-flatly.min.css', array('media' => 'screen')) }}
    {{ HTML::style('packages/spechal/lcgp/css/custom.css', array('media' => 'screen')) }}

    @yield('styles')

</head>
<body>

<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
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

{{ HTML::script('packages/spechal/lcgp/js/jquery-2.0.3.js') }}
{{ HTML::script('packages/spechal/lcgp/js/moment.js') }}
{{ HTML::script('packages/spechal/lcgp/js/bootstrap.min.js') }}
{{ HTML::script('packages/spechal/lcgp/js/custom.js') }}

@yield('scripts')

</body>
</html>