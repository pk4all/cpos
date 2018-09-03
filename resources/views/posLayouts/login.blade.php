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
        <link href="{{ asset("assets/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("assets/css/icons.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("assets/css/style.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("assets/css/custom.css")}}" rel="stylesheet" type="text/css" />
        <script src="{{ asset("assets/js/jquery.min.js")}}" type="text/javascript" async></script>
        <script src="{{ asset("assets/js/knockout.js")}}" type="text/javascript" async></script>
        <script src="{{ asset("assets/js/modernizr.min.js")}}" type="text/javascript" async></script>
        <script src="{{ asset("assets/js/popper.js")}}" type="text/javascript" async></script>
        <script src="{{ asset("assets/js/bootstrap.min.js")}}" type="text/javascript" async></script>
    </head>
    <body class="nopadd fullheight loginbg">
        
        @yield('body')
        @include('layouts.footer')
        
    </body>
</html>
