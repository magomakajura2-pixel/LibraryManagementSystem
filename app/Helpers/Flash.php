<?php
declare(strict_types=1);

namespace App\Helpers;

/**
 * Flash — one-time session messages (success / error / warning / info).
 */
final class Flash
{
    public static function set(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }

    public static function success(string $msg): void { self::set('success', $msg); }
    public static function error(string $msg): void   { self::set('danger', $msg); }
    public static function warning(string $msg): void { self::set('warning', $msg); }
    public static function info(string $msg): void    { self::set('info', $msg); }

    /** Render any pending flash messages as Bootstrap alerts. */
    public static function render(): string
    {
        if (empty($_SESSION['flash'])) {
            return '';
        }
        $html = '';
        foreach ($_SESSION['flash'] as $type => $message) {
            $safe = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
            $html .= '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">'
                    . $safe
                    . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'
                    . '</div>';
        }
        unset($_SESSION['flash']);
        return $html;
    }
}
