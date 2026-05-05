<?php
declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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

$_ENV['APP_PACKAGES_CACHE'] = $bootstrapCache . '/packages.php';
$_ENV['APP_SERVICES_CACHE'] = $bootstrapCache . '/services.php';
$_ENV['APP_CONFIG_CACHE'] = $bootstrapCache . '/config.php';
$_ENV['APP_ROUTES_CACHE'] = $bootstrapCache . '/routes.php';
$_ENV['APP_EVENTS_CACHE'] = $bootstrapCache . '/events.php';

putenv('APP_PACKAGES_CACHE=' . $_ENV['APP_PACKAGES_CACHE']);
putenv('APP_SERVICES_CACHE=' . $_ENV['APP_SERVICES_CACHE']);
putenv('APP_CONFIG_CACHE=' . $_ENV['APP_CONFIG_CACHE']);
putenv('APP_ROUTES_CACHE=' . $_ENV['APP_ROUTES_CACHE']);
putenv('APP_EVENTS_CACHE=' . $_ENV['APP_EVENTS_CACHE']);

$_SERVER['SCRIPT_FILENAME'] = $publicPath.'/index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['DOCUMENT_ROOT'] = $publicPath;

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null) {
        echo "FATAL ERROR OCCURRED: ";
        var_export($error);
    }
});

$_SERVER['HTTP_ACCEPT'] = 'application/json';

try {
    require $publicPath.'/index.php';
} catch (\Throwable $e) {
    echo "EXCEPTION CAUGHT: " . $e->getMessage() . "\n" . $e->getTraceAsString();
    if ($e->getPrevious()) {
        echo "\n\nPREVIOUS EXCEPTION: " . $e->getPrevious()->getMessage() . "\n" . $e->getPrevious()->getTraceAsString();
    }
}