<?php
declare(strict_types=1);

namespace App\Helpers;

/**
 * Redirect helper — PRG pattern.
 */
final class Redirect
{
    public static function to(string $url): never
    {
        // Prepend BASE_URL for root-relative paths (starting with /).
        // Full URLs (http://...) and empty strings are left untouched.
        if (str_starts_with($url, '/')) {
            $url = BASE_URL . $url;
        }
        header('Location: ' . $url);
        exit;
    }

    public static function back(): never
    {
        $ref = $_SERVER['HTTP_REFERER'] ?? '/dashboard/dashboard.php';
        self::to($ref);
    }

    public static function withError(string $url, string $message): never
    {
        Flash::error($message);
        self::to($url);
    }

    public static function withSuccess(string $url, string $message): never
    {
        Flash::success($message);
        self::to($url);
    }
}
