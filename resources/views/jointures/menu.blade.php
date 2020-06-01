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
                <span>Servers</span>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="feather icon-align-right"></i>
                    <span class="menu-title" data-i18n="Servers">List of server</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="feather icon-trending-up"></i>
                    <span class="menu-title" data-i18n="Users">Statistics</span>
                </a>
            </li>
            <li class=" nav-item">
                <a href="#">
                    <i class="feather icon-settings"></i>
                    <span class="menu-title" data-i18n="Ecommerce">
                        Settings
                    </span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="#">
                            <i class="feather icon-cloud-lightning"></i>
                            <span class="menu-item" data-i18n="Menu 1">Maintenance</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="feather icon-corner-down-right"></i>
                            <span class="menu-item" data-i18n="Menu 2">Others</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" navigation-header">
                <span>Announcements</span>
            </li>
            <li class=" nav-item">
                <a href="#">
                    <i class="feather icon-sliders"></i>
                    <span class="menu-title" data-i18n="management">management</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="#">
                            <i class="feather icon-plus"></i>
                            <span class="menu-item" data-i18n="Second Level">Create</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="feather icon-align-left"></i>
                            <span class="menu-item" data-i18n="Second Level">All Announcements</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="disabled nav-item">
                <a href="#">
                    <i class="feather icon-trending-up"></i>
                    <span class="menu-title"
                          data-i18n="Disabled Menu">Statistics</span>
                </a>
            </li>
            <li class=" navigation-header">
                <span>Users</span>
            </li>
            <li class=" nav-item">
                <a href="#">
                    <i class="feather icon-sliders"></i>
                    <span class="menu-title" data-i18n="management">management</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="#">
                            <i class="feather icon-users"></i>
                            <span class="menu-item" data-i18n="Second Level">Staff</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="feather icon-unlock"></i>
                            <span class="menu-item" data-i18n="Second Level">Permissions</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="disabled nav-item">
                <a href="#">
                    <i class="feather icon-list"></i>
                    <span class="menu-title"
                          data-i18n="Disabled Menu">List of users</span>
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
            <li class="navigation-header">
                <span>Settings</span>
            </li>
            <li class="nav-item">
                <a href="{{ route('Launcher Settings') }}">
                    <i class="feather icon-settings"></i>
                    <span class="menu-title" data-i18n="Launcher">Launcher</span>
                </a>
            </li>
        </ul>
    </div>
</div>
