<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\CSRF;
use App\Helpers\Redirect;

/**
 * CSRFMiddleware — validate CSRF on POST requests.
 */
final class CSRFMiddleware
{
    public static function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::check()) {
                Redirect::withError(
                    $_SERVER['HTTP_REFERER'] ?? '/dashboard/dashboard.php',
                    'Security token expired. Please try again.'
                );
            }
        }
    }
}
