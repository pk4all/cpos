<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>CPOS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="CPOS" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="{{ asset("assets/images/favicon.ico")}}">
        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="{{ asset("assets/plugins/morris/morris.css")}}">
        <!-- App css -->
        <link href="{{ asset("assets/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("assets/css/icons.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("assets/css/style.css")}}" rel="stylesheet" type="text/css" />
        <script src="{{ asset("assets/js/modernizr.min.js")}}"></script>
        @stack('head')
    </head>

    <body>
        <!-- jQuery  -->
        <script src="{{ asset("assets/js/jquery.min.js")}}"></script>
        <script src="{{ asset("assets/js/popper.min.js")}}"></script><!-- Popper for Bootstrap -->
        <script src="{{ asset("assets/js/bootstrap.min.js")}}"></script>
        <script src="{{ asset("assets/js/waves.js")}}"></script>
        <script src="{{ asset("assets/js/jquery.slimscroll.js")}}"></script>
        <script src="{{ asset("assets/js/jquery.scrollTo.min.js")}}"></script>
        <script src="{{ asset("assets/plugins/peity/jquery.peity.min.js")}}"></script>
        <script src="{{ asset("assets/pages/jquery.dashboard.js")}}"></script>
        <script src="{{ asset("assets/js/jquery.core.js")}}"></script>
        <script src="{{ asset("assets/js/jquery.app.js")}}"></script>

    </body>
</html>

