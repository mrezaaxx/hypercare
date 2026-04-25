<?php

declare(strict_types=1);

$publicPath = realpath(__DIR__.'/../public');

if ($publicPath === false) {
    http_response_code(500);
    echo 'Public path not found.';
    exit;
}

$storagePath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'simrs-laravel-storage';

foreach ([
    $storagePath,
    $storagePath.DIRECTORY_SEPARATOR.'app',
    $storagePath.DIRECTORY_SEPARATOR.'framework',
    $storagePath.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'cache',
    $storagePath.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'data',
    $storagePath.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'sessions',
    $storagePath.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'views',
    $storagePath.DIRECTORY_SEPARATOR.'logs',
] as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

$_ENV['LARAVEL_STORAGE_PATH'] = $storagePath;
$_SERVER['LARAVEL_STORAGE_PATH'] = $storagePath;
$_SERVER['SCRIPT_FILENAME'] = $publicPath.DIRECTORY_SEPARATOR.'index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['DOCUMENT_ROOT'] = $publicPath;

require $publicPath.DIRECTORY_SEPARATOR.'index.php';
