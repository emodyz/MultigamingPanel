<?php

return [
    'roles' => [
        'owner' => [
            'displayName' => 'Owner',
            'can' => [
                '*',
            ]
        ],
        'developer' => [
            'displayName' => 'Developer',
            'can' => [
                'dashboard',
                'users-index',

                'modpacks-create',
                'modpacks-index',
                'modpacks-edit',
                'modpacks-update',
                'modpacks-destroy',
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
            'can' => [
                'servers-index'
            ]
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

        /**
         * ModPacks
         */
        [
            'slug' => 'modpacks-index',
            'description' => 'a user can view a list of all modpacks'
        ],
        [
            'slug' => 'modpacks-create',
            'description' => 'a user can create a modpack'
        ],
        [
            'slug' => 'modpacks-update',
            'description' => 'a user can manage modpack updates'
        ],
        [
            'slug' => 'modpacks-edit',
            'description' => 'a user can edit a modpack'
        ],
        [
            'slug' => 'modpacks-destroy',
            'description' => 'a user can delete a modpack'
        ],

        /**
         * Servers
         */
        [
            'slug' => 'servers-index',
            'description' => 'a user can see a list of all servers'
        ],
        [
            'slug' => 'servers-create',
            'description' => 'a user can create a servers'
        ],
        [
            'slug' => 'servers-edit',
            'description' => 'a user can edit a servers'
        ],
        [
            'slug' => 'servers-destroy',
            'description' => 'a user can delete a servers'
        ],

        /**
         * Settings
         */
        [
            'slug' => 'settings-edit',
            'description' => 'a user can view the settings page'
        ],
        [
            'slug' => 'settings-edit-voice',
            'description' => 'a user can edit voice provider settings'
        ],
    ]
];
