<?php
/**
 * Last modified: 18.07.10 04:48:39
 * Hash: c0f1b9342e42d46e173a8303854e512f23ae1a20
 */


if (PHP_VERSION_ID < 70200) {
    die('PHP 7.2 is required');
}
foreach (['json', 'session', 'apcu', 'intl', 'mbstring', 'redis', 'pdo_pgsql'] as $name) {
    if (!extension_loaded($name)) {
        die($name . ' extension is not loaded');
    }
}

//ini_set('xdebug.remote_host', '0.0.0.0');
//ini_set('xdebug.remote_port', 8000);

defined('SITE') or define('SITE', __DIR__);

return [
    'driver' => 'pdo_sqlite',
    'path' => SITE . '/db.sqlite',
];
