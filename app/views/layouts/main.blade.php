<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @section('title')Content Management Framework
        @show
    </title>

    {{ HTML::style('assets/css/bootstrap-flatly.min.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/css/custom.css', array('media' => 'screen')) }}

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

{{ HTML::script('assets/js/jquery-2.0.3.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}

@yield('scripts')

</body>
</html>