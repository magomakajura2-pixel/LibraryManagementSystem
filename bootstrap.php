<?php
declare(strict_types=1);

/**
 * Bootstrap — autoloader, config, session start, CSRF on POST.
 * Every entry-point page requires this file first.
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/constants.php';

use App\Helpers\Session;
use App\Middleware\CSRFMiddleware;

Session::start();

// Validate CSRF token on every POST request.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRFMiddleware::handle();
}
