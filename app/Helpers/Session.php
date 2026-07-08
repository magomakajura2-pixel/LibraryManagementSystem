<?php
declare(strict_types=1);

namespace App\Helpers;

/**
 * Session — thin wrapper around PHP sessions.
 */
final class Session
{
    private static bool $started = false;


    public static function start(): void
    {
        if (self::$started || session_status() === PHP_SESSION_ACTIVE) {
            self::$started = true;
            return;
        }
        $cfg = require CONFIG_PATH . '/auth.php';
        session_name($cfg['session_name']);
        session_set_cookie_params([
            'lifetime' => $cfg['session_lifetime'],
            'path'     => '/',
            'httponly'  => true,
            'samesite'  => 'Strict',
        ]);
        session_start();
        self::$started = true;
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        session_unset();
        session_destroy();
        self::$started = false;
    }

    /** Convenience: is the user logged in? */
    public static function isLoggedIn(): bool
    {
        return self::has('user_id');
    }

    /** Get the logged-in user's role name. */
    public static function role(): ?string
    {
        return self::get('role_name');
    }

    /** Get the logged-in user's ID. */
    public static function userId(): ?int
    {
        $id = self::get('user_id');
        return $id !== null ? (int)$id : null;
    }
}
