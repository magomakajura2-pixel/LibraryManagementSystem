<?php
/**
 * Authentication & session configuration.
 */
return [
    'session_name'    => 'LMS_SESSION',
    'session_lifetime'=> 7200,              // 2 hours
    'login_url'       => '/auth/login.php',
    'dashboard_url'   => '/dashboard/dashboard.php',
    'role_redirects'  => [
        'admin'     => '/dashboard/dashboard.php',
        'librarian' => '/dashboard/dashboard.php',
        'assistant' => '/dashboard/dashboard.php',
    ],
    'role_permissions' => [
        'admin'     => ['dashboard','books','members','librarians','borrowings','returns','reports','settings'],
        'librarian' => ['dashboard','books','members','borrowings','returns','reports'],
        'assistant' => ['dashboard','books','borrowings','returns'],
    ],
];
