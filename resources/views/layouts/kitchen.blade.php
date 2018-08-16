<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport">
  <title>Expo Kitchen Screen</title>
  <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/kitchen-style-master.css')}}">
  <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
</head>

<body>
        @yield('body')
        @include('layouts.kitchen_footer') 
        <script type="text/javascript">
        $(document).ready(function () {
          $("#Completed").on('click', function () {
            $("#Completed-list").fadeIn();
            $("#Current-list").fadeOut();
            $("#Current").removeClass('active');
            $("#Completed").addClass('active');
          });
          $("#Current").on('click', function () {
            $("#Current-list").fadeIn();
            $("#Completed-list").fadeOut();
            $("#Completed").removeClass('active');
            $("#Current").addClass('active');
          });
        });
        function fullscreen() {
          if ((document.fullScreenElement && document.fullScreenElement !== null) ||
            (!document.mozFullScreen && !document.webkitIsFullScreen)) {
            if (document.documentElement.requestFullScreen) {
              document.documentElement.requestFullScreen();
            } else if (document.documentElement.mozRequestFullScreen) {
              document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullScreen) {
              document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            }
          } else {
            if (document.cancelFullScreen) {
              document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
              document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
              document.webkitCancelFullScreen();
            }
          }
        }
        </script>


        @yield('custome_script') 
    </body>
</html>
