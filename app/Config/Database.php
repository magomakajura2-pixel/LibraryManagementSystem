<?php
declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Database
 *
 * Single shared PDO connection for the whole application.
 * Credentials are read from environment variables so nothing sensitive
 * is hard-coded; sensible local defaults are provided for development.
 *
 * PDO is configured for security and predictable behaviour:
 *   - ERRMODE_EXCEPTION      : errors throw, never fail silently
 *   - EMULATE_PREPARES=false : real server-side prepared statements
 *   - DEFAULT_FETCH_MODE     : associative arrays
 */
final class Database
{
    private static ?PDO $pdo = null;

    /** Return the shared PDO connection, creating it on first use. */
    public static function connection(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $host    = getenv('DB_HOST')    ?: '127.0.0.1';
        $port    = getenv('DB_PORT')    ?: '3306';
        $name    = getenv('DB_NAME')    ?: 'library_management';
        $user    = getenv('DB_USER')    ?: 'root';
        $pass    = getenv('DB_PASS')    ?: '';
        $charset = getenv('DB_CHARSET') ?: 'utf8mb4';

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_STRINGIFY_FETCHES  => false,
        ];

        try {
            self::$pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            // Never leak credentials or the raw DSN to the client.
            throw new RuntimeException('Database connection failed.', 0, $e);
        }

        return self::$pdo;
    }

    /**
     * Tag the connection with the acting application user so the audit
     * triggers can record who performed each change (@app_user).
     */
    public static function setAppUser(string $identifier): void
    {
        $stmt = self::connection()->prepare('SET @app_user = :actor');
        $stmt->execute([':actor' => $identifier]);
    }

    private function __construct() {}
    private function __clone() {}
}
