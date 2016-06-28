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
 <div class="navbar navbar-inverse navbar-fixed-left">
  <a class="navbar-brand" href="#">VIF Process Lab</a>
  <ul class="nav navbar-nav">
   <li><a href="artifact-builder">Build</a></li>
    <ul role="menu">
    <li><a href="/artifact-builder/ask">Ask</a></li>
    <li><a href="#">Investigate</a></li>
    <li><a href="#">Synthesize</a></li>
    <li><a href="#">Share</a></li>
    <li><a href="#">Reflect</a></li>
    </ul>
   <li><a href="/artifact-builder/tag">Tag</a></li>
   <li><a href="#">Collaborate</a></li>
   <li><a href="#">Notes from the field</a></li>
  </ul>
  <ul class="nav navbar-nav">
    <li><button href="#" class="btn btn-default">Submit for Peer Review</a></button>
    <li><br/></li>
    <li><button href="#" class="btn btn-default">Submit for Expert Review</a></button>
    </ul>
</div>

    @yield('content')

    <!-- JavaScripts -->
    <script src="{{ asset('/js/vendor.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>
    <script src="{{ asset('/js/components.js') }}"></script>
</body>
</html>
