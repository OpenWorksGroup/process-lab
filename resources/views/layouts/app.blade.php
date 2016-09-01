<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>

    <title>{{$siteTitle}}{{ isset($pageTitle) ? '| '.$pageTitle : '' }}</title>
    
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <link rel="stylesheet" href="https://npmcdn.com/react-select/dist/react-select.css">

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
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
                    {{$siteTitle}}
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
                                @if(Session::has('user.admin'))
                                    <li><a href="{{ url('/admin') }}">Admin Dashboard</a></li>
                                @endif
                                    <li><a href="/dashboard">Dashboard</a></li>
                                    <li><a href="{{ url('/logout') }}">Logout</a></li>
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

        $(document).ready(function () {
            //review form modal confirm
            $('#reviewFormButton').on('click', function(e){
                e.preventDefault();
            });
            $('#reviewModal').on('show.bs.modal', function (e) {       
                var form = $(e.relatedTarget).closest('form');
                $(this).find('.modal-footer #confirm').data('form', form);
            });
            $('#reviewModal').find('.modal-footer #confirm').on('click', function(){
                $(this).data('form').submit();
            });

            //delete artifact modal confirm content id
            $('#deleteArtifactModal').on('show.bs.modal', function(e) {
                var contentId = $(e.relatedTarget).data('id');
                $("#deleteLink").attr("href", "/artifact-delete/"+contentId);
            });
        });

    </script>
    <script src="{{ asset('/js/components.js') }}"></script>
</body>
</html>
