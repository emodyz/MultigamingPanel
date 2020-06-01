<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/ico/favicon.ico')}}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link href="{{ asset('vendors/css/vendors.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/charts/apexcharts.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/extensions/tether-theme-arrows.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/extensions/tether.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/extensions/shepherd-theme-default.css') }}" rel="stylesheet">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link type="text/css" href="{{ asset('css/bootstrap.css')}}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/bootstrap-extended.css')}}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/colors.css')}}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/components.css')}}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/themes/dark-layout.css')}}" rel="stylesheet">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link href="{{ asset('css/core/menu/menu-types/vertical-menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/core/colors/palette-gradient.css') }}" rel="stylesheet">
    @yield('css')
    <!-- END: Page CSS-->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="vertical-layout vertical-menu-modern dark-layout 2-columns  navbar-floating footer-static"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="dark-layout">
<div id="app">

    <!-- BEGIN: Header-->
@include("jointures/header")
<!-- END: Header-->

    <!-- BEGIN: Main Menu-->
@include("jointures/menu")
<!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    @include("jointures/footer")
    <!-- END: Footer-->


</div>
<!-- BEGIN: Vendor JS-->
<script src="{{asset("vendors/js/vendors.min.js")}}"></script>

<script src="{{asset("vendors/js/charts/apexcharts.min.js")}}"></script>
<script src="{{asset("vendors/js/extensions/tether.min.js")}}"></script>
<script src="{{asset("vendors/js/extensions/shepherd.min.js")}}"></script>
<!-- END: Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset("js/core/app-menu.js")}}"></script>
<script src="{{asset("js/core/app.js")}}"></script>
<script src="{{asset("js/scripts/components.js")}}"></script>
<!-- END: Theme JS-->

@yield('script')
</body>
</html>
