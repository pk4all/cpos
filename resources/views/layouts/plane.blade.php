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
        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="{{ asset("assets/plugins/morris/morris.css")}}">
        <link rel="stylesheet"  href="{{ asset("assets/plugins/clockpicker/css/bootstrap-clockpicker.min.css")}}"/>
        <!-- App css -->
        <link href="{{ asset("assets/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet" type="text/css" />
       	<link rel="stylesheet" href="{{ ('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" />
        <link href="{{ asset("assets/css/icons.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("assets/css/style.css")}}" rel="stylesheet" type="text/css" />
        <script src="{{ asset("assets/js/modernizr.min.js")}}"></script>
        <script src="{{ asset('assets/js/knockout.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
        @stack('head')
    </head>

    <body>
        @if(Auth::user())
        @include('layouts.header')
        @endif
        @yield('body')
        @include('layouts.footer')

        <!-- jQuery  -->

        <script src="{{ asset('assets/js/popper.min.js')}}"></script><!-- Popper for Bootstrap -->
        <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('assets/js/waves.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.scrollTo.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/peity/jquery.peity.min.js')}}"></script>

        <!-- jQuery  -->
       <!-- <script src="{{ asset("assets/plugins/waypoints/lib/jquery.waypoints.min.js")}}"></script>
        <script src="{{ asset("assets/plugins/counterup/jquery.counterup.min.js")}}"></script>

        <script src="{{ asset("assets/plugins/morris/morris.min.js")}}"></script>
        <script src="{{ asset("assets/plugins/raphael/raphael-min.js")}}"></script>

        <script src="{{ asset("assets/plugins/jquery-knob/jquery.knob.js")}}"></script>-->

        <script src="{{ asset("assets/pages/jquery.dashboard.js")}}"></script>
        <script src="{{ asset("assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js")}}"></script>

        <script src="{{ asset("assets/js/jquery.core.js")}}"></script>
        <script src="{{ asset("assets/js/jquery.app.js")}}"></script>
        <script src="{{ asset("assets/js/common.js")}}"></script>

        <script src="{{ asset("assets/pages/jquery.dashboard.js")}}"></script> -->
        <script src="{{ asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.core.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.app.js')}}"></script>
        <script src="{{ asset('assets/js/common.js')}}"></script>
        <script type="text/javascript">

        </script>


        @yield('custome_script') 
    </body>
</html>
