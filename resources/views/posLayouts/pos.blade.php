<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>CPOS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="CPOS" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}">
		
        <!-- App css -->
		<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
       <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
       <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" />
       <link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
		
		
        <script src="{{ asset('assets/js/modernizr.min.js')}}"></script>
        <script src="{{ asset('assets/js/knockout.js')}}"></script>	
       <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
       <script src="{{ asset('assets/js/popper.min.js')}}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
        
        @stack('head')
    </head>

    <body class="graybg fullheight">
        @if(Auth::user())
        @include('posLayouts.pos_header')
        @endif
        @yield('body')
        @include('posLayouts.pos_footer')
    </body>
</html>
