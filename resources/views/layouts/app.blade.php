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

    @include('jointures/styles')
    <!-- END: Page CSS-->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="vertical-layout vertical-menu-modern dark-layout 2-columns navbar-floating fixed-footer"
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
@include('jointures/scripts')
</body>
</html>
