<!DOCTYPE html>
<html class=" js flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="zxx" style=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<head>
    <meta charset="utf-8" />
    <title>Operamenu</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="meta description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">var APP_URL = {!! json_encode(url('/')) !!};</script>
    <script type="text/javascript">var LANGUAGE = '{{ \Illuminate\Support\Facades\Session::has('lang') ? \Illuminate\Support\Facades\Session::get('lang') : 'en' }}'</script>

    @yield('css')
    <!--=== Favicon ===-->
    <link rel="shortcut icon" href="{{asset('front/grocery/images/logo.png')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link href="{{ asset('front/grocery/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('front/grocery/css/swiper.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('front/grocery/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{ asset('front/grocery/css/styles.css')}}" rel="stylesheet">
    <link href="{{ asset('front/grocery/css/beyond_the_mountains-webfont.css')}}" rel="stylesheet">
    <style type="text/css">
       .symbol-btn-back-to-top {
  font-size: 22px;
  color: white;
  line-height: 1em;
}
.btn-back-to-top {
  display: none;
  position: fixed;
  width: 40px;
  height: 40px;
  bottom: 8px;
  right: 40px;
  background-color: #cfb62c;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  border-radius: 4px;
  transition: all 0.4s;
  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
}
.btn-back-to-top:hover {
  opacity: 1;
  cursor: pointer;
}
@media (max-width: 576px) {
  .btn-back-to-top {
    bottom: 8px;
    right: 15px;
  }
}
.bg0-hov:hover {background-color: #cfb62c;}
    </style>
</head>
<body>

@yield('loader')

@yield('header')

@yield('content')


@yield('footer')

<!-- javascript -->
@yield('slider')

<script src="{{ asset('front/grocery/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('front/grocery/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/grocery/js/swiper.js') }}"></script>
<script src="{{ asset('front/grocery/js/scripts.js') }}"></script>
<script type="text/javascript">
    var windowH = $(window).height()/2;

    $(window).on('scroll',function(){
        if ($(this).scrollTop() > windowH) {
            $("#myBtn").css('display','flex');
        } else {
            $("#myBtn").css('display','none');
        }
    });

    $('#myBtn').on("click", function(){
        $('html, body').animate({scrollTop: 0}, 300);
    });
</script>
@yield('javascript')
</body>
</html>
