<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="/">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">{{ config('app.name') }}</h2>
                </a></li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                    <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                       data-ticon="icon-disc">
                    </i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item">
                <a href="#">
                    <i class="feather icon-home"></i>
                    <span class="menu-title"
                          data-i18n="Dashboard">Dashboard</span>
                    <span class="badge badge badge-warning badge-pill float-right mr-2">
                        2
                    </span>
                </a>
                <ul class="menu-content">
                    <li class="{{Route::currentRouteName() === 'dashboard' ? 'active': ''}}">
                        <a href="{{route('dashboard')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Dashboard">Analytics</span>
                        </a>
                    </li>
                    <li  class="{{Route::currentRouteName() === 'home' ? 'active': ''}}">
                        <a href="{{ route('home') }}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Home">Home</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="navigation-header">
                <span>Settings</span>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="feather icon-settings"></i>
                    <span class="menu-title" data-i18n="Launcher">Launcher</span>
                </a>
            </li>
            <li class="navigation-header">
                <span>App</span>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="feather icon-server"></i>
                    <span class="menu-title" data-i18n="Servers">Servers</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="feather icon-users"></i>
                    <span class="menu-title" data-i18n="Users">Users</span>
                </a>
            </li>
            <li class=" nav-item">
                <a href="#">
                    <i class="feather icon-shopping-cart"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        Menu
                    </span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="#">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Menu 1">Menu 1</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Menu 2">Menu 2</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" navigation-header">
                <span>Others</span>
            </li>
            <li class=" nav-item">
                <a href="#">
                    <i class="feather icon-menu"></i>
                    <span class="menu-title" data-i18n="Menu Levels">Menu Levels</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="#">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Second Level">Second Level</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Second Level">Second Level</span>
                        </a>
                        <ul class="menu-content">
                            <li>
                                <a href="#">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item"
                                          data-i18n="Third Level">Third Level</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="feather icon-circle"></i>
                                    <span class="menu-item"
                                          data-i18n="Third Level">Third Level</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="disabled nav-item">
                <a href="#">
                    <i class="feather icon-eye-off"></i>
                    <span class="menu-title"
                          data-i18n="Disabled Menu">Disabled Menu</span>
                </a>
            </li>
            <li class=" navigation-header">
                <span>Support</span>
            </li>
            <li class=" nav-item">
                <a href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/documentation">
                    <i class="feather icon-folder"></i>
                    <span class="menu-title" data-i18n="Documentation">Documentation</span>
                </a>
            </li>
            <li class=" nav-item">
                <a href="https://pixinvent.ticksy.com/">
                    <i class="feather icon-life-buoy"></i>
                    <span class="menu-title" data-i18n="Raise Support">Raise Support</span>
                </a>
            </li>
        </ul>
    </div>
</div>
