<?php require_once __DIR__.'/../bootstrap.php';
\App\Middleware\AuthMiddleware::handle();
\App\Middleware\RoleMiddleware::require('admin');
(new \App\Controllers\LibrarianController())->update();
