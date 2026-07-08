<?php
declare(strict_types=1);

namespace App\Helpers;

/**
 * CSRF — token generation and validation.
 */
final class CSRF
{
    private static string $key = 'csrf_token';

    /** Generate a token and store it in the session. */
    public static function generate(): string
    {
        $token = bin2hex(random_bytes(32));
        Session::set(self::$key, $token);
        return $token;
    }

    /** Get the current token (generates one if missing). */
    public static function token(): string
    {
        return Session::get(self::$key) ?? self::generate();
    }

    /** Render a hidden HTML input field. */
    public static function field(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . self::token() . '">';
    }

    /** Validate a submitted token against the session token. */
    public static function validate(?string $submitted): bool
    {
        $stored = Session::get(self::$key);
        if ($stored === null || $submitted === null) {
            return false;
        }
        return hash_equals($stored, $submitted);
    }

    /** Validate and regenerate in one call. */
    public static function check(): bool
    {
        $valid = self::validate($_POST['csrf_token'] ?? null);
        self::generate(); // rotate after every check
        return $valid;
    }
}
