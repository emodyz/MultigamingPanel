<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="/">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">{{ config('app.name') }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                    <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary collapse-toggle-icon"
                       data-ticon="icon-disc">
                    </i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- Foreach menu item starts --}}

            @foreach(config('menu') as $menu)
                @if(isset($menu->navheader) && $menu->navheader === true)
                    <li class="navigation-header">
                        <span>{{ __($menu->i18n) }}</span>
                    </li>
                @else
                    {{-- Add Custom Class with nav-item --}}
                    <li class="nav-item {{ (isset($menu->url) ? request()->is($menu->url) : request()->routeIs($menu->route_name)) ? 'active' : '' }} {{ $menu->classlist ?? '' }}">
                        <a href="{{ $menu->url ?? route($menu->route_name) }}">
                            <i class="{{ $menu->icon }}"></i>
                            <span class="menu-title"
                                  data-i18n="{{ $menu->i18n ?? '' }}">{{ __($menu->i18n ?? '') }}</span>
                            @if (isset($menu->badge))
                                <span
                                    class="{{ isset($menu->badgeClass) ? $menu->badgeClass.' test' : 'badge badge-pill badge-primary float-right notTest' }} ">{{$menu->badge}}</span>
                            @endif
                        </a>
                        @if(isset($menu->submenu))
                            @include('jointures/submenu', ['menu' => $menu->submenu])
                        @endif
                    </li>
                @endif
            @endforeach
            {{-- Foreach menu item ends --}}
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
