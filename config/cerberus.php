<?php

return [
    'roles' => [
        'owner' => [
            'displayName' => 'Owner',
            'can' => [
                '*'
            ]
        ],
        'admin' => [
            'displayName' => 'Administrator',
            'can' => [
                'dashboard',
                'users-index'
            ]
        ],
        'default' => [
            'displayName' => 'User',
            'can' => []
        ]
    ],
    'authorizations' => [
        [
            'slug' => '*',
            'description' => 'a user can do everything'
        ],
        [
            'slug' => 'admin-dashboard',
            'description' => 'a user can view the administration dashboard'
        ],
    ]
];
