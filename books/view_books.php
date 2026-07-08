<?php
require_once __DIR__ . '/../bootstrap.php';
\App\Middleware\AuthMiddleware::handle();
(new \App\Controllers\BookController())->index();
