<?php

return json_decode(json_encode([
    [
        "route_name" => 'dashboard',
        "i18n" => 'menu.dashboard',
        "badge" => "2",
        "badgeClass" => "badge badge-warning badge-pill float-right",
        "icon" => "feather icon-users"
    ],
    [
        "route_name" => 'home',
        "i18n" => 'menu.home',
        "icon" => "feather icon-home"
    ],
    [
        "url" => "#",
        "i18n" => 'menu.servers',
        "icon" => "feather icon-zap",
        "submenu" => [
            [
                "route_name" => "servers.index",
                "i18n" => 'menu.common.list'
            ],
            [
                "route_name" => "servers.create",
                "i18n" => 'menu.common.create'
            ]
        ]
    ],
    [
        "url" => "",
        "navheader" => true,
        "i18n" => 'menu.support'
    ],
    [
        "url" => "https://github.com/emodyz/MultigamingPanel/wiki",
        "icon" => "feather icon-folder",
        "i18n" => "menu.documentation"
    ],
    [
        "url" => "email:support@emodyz.eu",
        "icon" => "feather icon-life-buoy",
        "i18n" => "menu.raise_support"
    ]
]));
