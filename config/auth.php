<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

    'session_name'    => 'LMS_SESSION',
    'session_lifetime'=> 7200,
    'login_url'       => '/login',
    'dashboard_url'   => '/dashboard',
    'role_redirects'  => [
        'admin'     => '/dashboard',
        'librarian' => '/dashboard',
        'assistant' => '/dashboard',
    ],
    'role_permissions' => [
        'admin'     => ['dashboard','books','members','librarians','borrowings','returns','reports','settings'],
        'librarian' => ['dashboard','books','members','borrowings','returns','reports'],
        'assistant' => ['dashboard','books','borrowings','returns'],
    ],

];
