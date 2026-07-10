<?php
/**
 * Application-wide constants.
 */

if (!defined('APP_NAME'))    define('APP_NAME',    env('APP_NAME', 'MAGA Community Library'));
if (!defined('APP_VERSION')) define('APP_VERSION', '1.0.0');

// Base paths
if (!defined('BASE_PATH'))   define('BASE_PATH', dirname(__DIR__));
if (!defined('APP_PATH'))    define('APP_PATH',  BASE_PATH . '/app');
if (!defined('CONFIG_PATH')) define('CONFIG_PATH', BASE_PATH . '/config');

// Base URL
$docRoot    = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? '');
$basePath   = str_replace('\\', '/', BASE_PATH);
$urlBase    = substr($basePath, strlen(rtrim($docRoot, '/')));
if (!defined('BASE_URL')) define('BASE_URL', rtrim($urlBase, '/'));

// Pagination
if (!defined('RECORDS_PER_PAGE')) define('RECORDS_PER_PAGE', 15);

// Loan defaults
if (!defined('DEFAULT_LOAN_DAYS'))    define('DEFAULT_LOAN_DAYS', 14);
if (!defined('MAX_LOANS_PER_MEMBER')) define('MAX_LOANS_PER_MEMBER', 5);

// Upload
if (!defined('UPLOAD_PATH'))     define('UPLOAD_PATH', BASE_PATH . '/assets/uploads');
if (!defined('MAX_UPLOAD_SIZE')) define('MAX_UPLOAD_SIZE', 2 * 1024 * 1024);

// Date format
if (!defined('DATE_DISPLAY')) define('DATE_DISPLAY', 'd M Y');
if (!defined('DATE_DB'))      define('DATE_DB',      'Y-m-d');
