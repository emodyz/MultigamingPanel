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
            'can' => []
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
    ]
];
