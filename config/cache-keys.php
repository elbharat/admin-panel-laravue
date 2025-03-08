<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cache Keys
    |--------------------------------------------------------------------------
    |
    | This file contains all cache keys used in the application.
    | It's a good practice to define all cache keys in one place
    | to avoid duplication and make it easier to manage.
    |
    */

    'users' => [
        'with_roles' => 'users.with.roles',
    ],

    'dashboard' => [
        'admin_data' => 'admin.dashboard.data',
    ],

    // Cache TTL in seconds
    'ttl' => [
        'short' => 60, // 1 minute
        'medium' => 60 * 5, // 5 minutes
        'long' => 60 * 60, // 1 hour
        'day' => 60 * 60 * 24, // 1 day
    ],
]; 