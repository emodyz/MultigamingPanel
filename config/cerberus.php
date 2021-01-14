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
                'users-index',
                'users-edit'
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
        /**
         * Users Management
         */
        [
            'slug' => 'users-index',
            'description' => 'a user can view a list of all users'
        ],
        [
            'slug' => 'users-edit',
            'description' => 'a user can edit another user\'s profile'
        ],
        [
            'slug' => 'users-edit-account',
            'description' => 'a user can edit another user\'s account'
        ],
        [
            'slug' => 'users-destroy',
            'description' => 'a user can delete other users'
        ],
        [
            'slug' => 'users-destroy',
            'description' => 'a user can delete other users'
        ],
        /**
         * Articles
         */
        [
            'slug' => 'articles-index',
            'description' => 'a user can manage articles'
        ],
        [
            'slug' => 'articles-create',
            'description' => 'a user can write a new article'
        ],
        [
            'slug' => 'articles-edit',
            'description' => 'a user can edit articles'
        ],
        [
            'slug' => 'articles-destroy',
            'description' => 'a user can delete articles'
        ],
    ]
];
