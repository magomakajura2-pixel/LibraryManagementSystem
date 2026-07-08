<?php
/**
 * Database configuration.
 * In production, pull from environment variables or a .env file.
 */
return [
    'host'    => getenv('DB_HOST')    ?: '127.0.0.1',
    'port'    => getenv('DB_PORT')    ?: '3306',
    'name'    => getenv('DB_NAME')    ?: 'library_management',
    'user'    => getenv('DB_USER')    ?: 'root',
    'pass'    => getenv('DB_PASS')    ?: '',
    'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
];
