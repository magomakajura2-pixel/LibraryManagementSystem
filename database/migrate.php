<?php
declare(strict_types=1);

/**
 * migrate.php — minimal migration & seed runner.
 *
 * Usage:
 *   php database/migrate.php            # run pending migrations
 *   php database/migrate.php --seed     # run migrations, then seeds
 *   php database/migrate.php --fresh    # DROP the schema, then migrate (+ --seed)
 *
 * Connection is taken from the same DB_* environment variables used by
 * App\Config\Database. Each migration runs exactly once; applied files are
 * tracked in the schema_migrations table.
 */

$root = dirname(__DIR__);
require $root . '/app/Config/Database.php';

use App\Config\Database;

$args   = $argv;
$doSeed = in_array('--seed', $args, true);
$fresh  = in_array('--fresh', $args, true);

$dbName = getenv('DB_NAME') ?: 'library_management';

/* Connect to the server without selecting a database first, so --fresh and
   CREATE DATABASE work on a clean host. */
$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

$bootstrap = new PDO(
    "mysql:host={$host};port={$port};charset=utf8mb4",
    $user, $pass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

if ($fresh) {
    echo "Dropping database {$dbName} ...\n";
    $bootstrap->exec("DROP DATABASE IF EXISTS `{$dbName}`");
}
$bootstrap->exec(
    "CREATE DATABASE IF NOT EXISTS `{$dbName}`
     CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
);

/* From here on use the app connection (selects the database). */
putenv("DB_NAME={$dbName}");
$pdo = Database::connection();

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS schema_migrations (
        filename   VARCHAR(191) NOT NULL PRIMARY KEY,
        applied_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
     ) ENGINE=InnoDB'
);

$applied = $pdo->query('SELECT filename FROM schema_migrations')
               ->fetchAll(PDO::FETCH_COLUMN);
$applied = array_flip($applied);

/** Execute one .sql file. Routine files (trigger/procedure/function) are sent
 *  as a single statement; everything else is split on ';'. */
$runFile = static function (PDO $pdo, string $path) : void {
    $sql       = file_get_contents($path);
    $isRoutine = (bool) preg_match('/CREATE\s+(TRIGGER|PROCEDURE|FUNCTION)/i', $sql);

    if ($isRoutine) {
        $pdo->exec($sql);                       // one compound statement
        return;
    }

    // Strip whole-line comments, then split on ';'.
    $lines = preg_split('/\R/', $sql);
    $clean = array_filter($lines, static fn ($l) => !preg_match('/^\s*--/', $l));
    $body  = implode("\n", $clean);

    foreach (explode(';', $body) as $stmt) {
        if (trim($stmt) !== '') {
            $pdo->exec($stmt);
        }
    }
};

$record = $pdo->prepare('INSERT INTO schema_migrations (filename) VALUES (:f)');

/** Apply every *.sql in a directory in filename order. */
$applyDir = static function (string $dir, string $label) use ($pdo, $applied, $record, $runFile) : void {
    if (!is_dir($dir)) {
        return;
    }
    $files = glob($dir . '/*.sql');
    sort($files, SORT_STRING);

    foreach ($files as $file) {
        $name = basename($file);
        $key  = $label . '/' . $name;
        if (isset($applied[$key])) {
            continue;
        }
        echo "  applying {$key} ... ";
        $runFile($pdo, $file);
        $record->execute([':f' => $key]);
        echo "ok\n";
    }
};

echo "Running migrations:\n";
$applyDir($root . '/database/migrations', 'migrations');

if ($doSeed) {
    echo "Running seeds:\n";
    $applyDir($root . '/database/seeds', 'seeds');
}

echo "Done.\n";
