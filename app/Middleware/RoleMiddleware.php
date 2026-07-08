<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\Session;
use App\Helpers\Redirect;

/**
 * RoleMiddleware — restricts pages to certain roles.
 */
final class RoleMiddleware
{
    /** Require the current user to hold one of the given roles. */
    public static function require(string ...$allowed): void
    {
        $role = Session::role();
        if ($role === null || !in_array($role, $allowed, true)) {
            Redirect::withError('/dashboard/dashboard.php', 'You do not have permission to access that page.');
        }
    }
}
