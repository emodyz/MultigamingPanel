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
    <link href="{{ asset('css/pages/authentication.css') }}" rel="stylesheet">
@yield('css')
<!-- END: Page CSS-->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body
    class="vertical-layout vertical-menu-modern dark-layout 1-column  navbar-floating footer-static bg-full-screen-image blank-page blank-page"
    data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="dark-layout">
<div id="app">

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-11 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0" style="background: rgb(0,14,20);">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                    <img
                                        src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse2.mm.bing.net%2Fth%3Fid%3DOIP.SPScoCxvLka3e0f5UdyAAgHaHa%26pid%3DApi&f=1"
                                        alt="branding logo" style="width: 100%;">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Login</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">
                                            Welcome back, please login to your account.
                                        </p>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                @yield('content')
                                            </div>
                                        </div>
                                        <div class="login-footer">
                                            <div class="divider">
                                                <div class="divider-text">OR</div>
                                            </div>
                                            <div class="footer-btn d-inline">
                                                <a href="#" class="btn btn-facebook"><span
                                                        class="fa fa-facebook"></span></a>
                                                <a href="#" class="btn btn-twitter white"><span
                                                        class="fa fa-twitter"></span></a>
                                                <a href="#" class="btn btn-google"><span
                                                        class="fa fa-google"></span></a>
                                                <a href="#" class="btn btn-github"><span
                                                        class="fa fa-github-alt"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->

</div>
<!-- BEGIN: Vendor JS-->
<script src="{{asset("vendors/js/vendors.min.js")}}"></script>
<!-- END: Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset("js/core/app-menu.js")}}"></script>
<script src="{{asset("js/core/app.js")}}"></script>
<script src="{{asset("js/scripts/components.js")}}"></script>
<!-- END: Theme JS-->

@yield('script')
</body>
</html>
