<?php
/**
 * Application-wide constants.
 */

define('APP_NAME',    'MAGA Community Library');
define('APP_VERSION', '1.0.0');

// Base paths
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH',  BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');

// Base URL — auto-detected so the app works in both root and subdirectory deployments
$docRoot    = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? 'C:/xampp/htdocs');
$basePath   = str_replace('\\', '/', BASE_PATH);
$urlBase    = substr($basePath, strlen(rtrim($docRoot, '/')));
define('BASE_URL', rtrim($urlBase, '/'));

// Pagination
define('RECORDS_PER_PAGE', 15);

// Loan defaults
define('DEFAULT_LOAN_DAYS', 14);
define('MAX_LOANS_PER_MEMBER', 5);

// Upload
define('UPLOAD_PATH', BASE_PATH . '/assets/uploads');
define('MAX_UPLOAD_SIZE', 2 * 1024 * 1024); // 2 MB

// Date format
define('DATE_DISPLAY', 'd M Y');
define('DATE_DB',      'Y-m-d');
