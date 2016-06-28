<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>

    <title>{{ $siteTitle }} {{ isset($pageTitle) ? '| '.$pageTitle : '' }}</title>
    
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <link rel="stylesheet" href="https://npmcdn.com/react-select/dist/react-select.css">

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
     
    <script src="https://use.typekit.net/rqb4xyg.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>
    

</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ $siteTitle }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                       <li><a href="{{ url('/login') }}">Login</a></li>
                       <!-- <li><a href="{{ url('/register') }}">Register</a></li> -->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/admin') }}"><i class="fa fa-btn fa-sign-out"></i>Admin Dashboard</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="{{ asset('/js/vendor.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>
    <script src="{{ asset('/js/components.js') }}"></script>
            <script type="text/javascript">
        $( document ).ready(function() {
            $("#build-section").hide();
            $("#build" ).click(function() {
                if($('#build-section:visible').length) {
                    $("#build-section").hide();
                }
                else {
                    $("#build-section").show();
                }
            });
            $("#ask-section").hide();
            $("#ask" ).click(function() {
                if($('#ask-section:visible').length) {
                    $("#ask-section").hide();
                }
                else {
                    $("#ask-section").show();
                }
            });

            $("#investigate-section").hide();
            $("#investigate" ).click(function() {
                if($('#investigate-section:visible').length) {
                    $("#investigate-section").hide();
                }
                else {
                    $("#investigate-section").show();
                }
            });

            $("#synth-section").hide();
            $("#synth" ).click(function() {
                if($('#synth-section:visible').length) {
                    $("#synth-section").hide();
                }
                else {
                    $("#synth-section").show();
                }
            });

            $("#share-section").hide();
            $("#share" ).click(function() {
                if($('#share-section:visible').length) {
                    $("#share-section").hide();
                }
                else {
                    $("#share-section").show();
                }
            });

            $("#reflect-section").hide();
            $("#reflect" ).click(function() {
                if($('#reflect-section:visible').length) {
                    $("#reflect-section").hide();
                }
                else {
                    $("#reflect-section").show();
                }
            });

            $("#tag-section").hide();
            $("#tag" ).click(function() {
                if($('#tag-section:visible').length) {
                    $("#tag-section").hide();
                }
                else {
                    $("#tag-section").show();
                }
            });

            $("#collaborate-section").hide();
            $("#collaborate" ).click(function() {
                if($('#collaborate-section:visible').length) {
                    $("#collaborate-section").hide();
                }
                else {
                    $("#collaborate-section").show();
                }
            });

            $("#notes-section").hide();
            $("#notes" ).click(function() {
                if($('#notes-section:visible').length) {
                    $("#notes-section").hide();
                }
                else {
                    $("#notes-section").show();
                }
            });

        });
    </script>
</body>
</html>
