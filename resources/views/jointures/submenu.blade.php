{{-- For submenu --}}
<ul class="menu-content">
    @foreach($menu as $submenu)
        <li class="{{ (isset($submenu->url) ? request()->is($submenu->url) : request()->routeIs($submenu->route_name)) ? 'active' : '' }}">
            <a href="{{ $submenu->url ?? route($submenu->route_name) }}">
                <i class="{{ $submenu->icon ?? "" }}"></i>
                <span class="menu-title" data-i18n="{{ $submenu->i18n ?? '' }}">{{ __($submenu->i18n ?? '') }}</span>
            </a>
            @if (isset($submenu->submenu))
                @include('jointures/submenu', ['menu' => $submenu->submenu])
            @endif
        </li>
    @endforeach
</ul>
