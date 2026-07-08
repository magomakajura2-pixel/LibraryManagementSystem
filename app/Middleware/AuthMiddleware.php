<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\Session;
use App\Helpers\Redirect;

/**
 * AuthMiddleware — redirects unauthenticated users to login.
 */
final class AuthMiddleware
{
    public static function handle(): void
    {
        Session::start();
        if (!Session::isLoggedIn()) {
            Redirect::to('/auth/login.php');
        }
    }
}
