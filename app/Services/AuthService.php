<?php
declare(strict_types=1);

namespace App\Services;

use App\Config\Database;
use App\Models\User;
use App\Helpers\Session;

class AuthService
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Attempt login. On success, populate the session and return the user row.
     */
    public function login(string $username, string $password): ?array
    {
        $user = $this->user->attemptLogin($username, $password);
        if ($user === null) {
            return null;
        }

        // Regenerate to prevent session fixation.
        session_regenerate_id(true);

        Session::set('user_id',   $user['user_id']);
        Session::set('username',  $user['username']);
        Session::set('role_name', $user['role_name']);
        Session::set('email',     $user['email']);

        Database::setAppUser($user['username']);

        return $user;
    }

    public function logout(): void
    {
        Session::destroy();
    }
}
