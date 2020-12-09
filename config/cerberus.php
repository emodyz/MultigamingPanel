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
            'slug' => 'dashboard',
            'description' => 'a user can view the administration dashboard'
        ],
        [
            'slug' => 'users-index',
            'description' => 'a user can view a list of all users'
        ],
        [
            'slug' => 'users-edit',
            'description' => 'a user can edit other users'
        ],
    ]
];
