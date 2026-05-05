<?php
declare(strict_types=1);

$publicPath = realpath(__DIR__.'/../public');
if ($publicPath === false) {
    http_response_code(500);
    echo 'Public path not found.';
    exit;
}

$storagePath = sys_get_temp_dir().'/hypercare-storage';
$bootstrapCache = sys_get_temp_dir().'/hypercare-bootstrap-cache';

foreach ([
    $storagePath,
    $storagePath.'/app',
    $storagePath.'/app/public',
    $storagePath.'/framework',
    $storagePath.'/framework/cache',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
    $bootstrapCache,
] as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

$_ENV['APP_STORAGE_PATH'] = $storagePath;
$_ENV['APP_BOOTSTRAP_CACHE'] = $bootstrapCache;

// Run migrations once per Lambda instance
$dbPath = '/tmp/database.sqlite';
$migrationFlag = '/tmp/hypercare-migrated';

if (! file_exists($dbPath)) {
    touch($dbPath);
}

if (! file_exists($migrationFlag)) {
    $appRoot = dirname(__DIR__);
    shell_exec("cd {$appRoot} && php artisan migrate --force 2>&1");
    touch($migrationFlag);
}

$_SERVER['SCRIPT_FILENAME'] = $publicPath.'/index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['DOCUMENT_ROOT'] = $publicPath;

require $publicPath.'/index.php';