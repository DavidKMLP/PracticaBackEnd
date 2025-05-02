<?php

use Monolog\Level as MonologLevel;

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Timezone
date_default_timezone_set('Europe/Madrid');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/var';
$settings['public'] = $settings['root'] . '/public';

// Error Handling Middleware settings
$settings['error_handler_middleware'] = [
    // Should be set to false in production
    'display_error_details' => true,
    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests it should be disable too
    'log_errors' => true,
    // Display error details in error log
    'log_error_details' => true,
];

// Application settings
$settings['app'] = [
    'secret' => $_ENV['JWT_SECRET'],
];

// Logger settings
$settings['logger'] = [
    'name' => 'app',
    'path' => $settings['temp'] . '/logs',
    'filename' => 'app.log',
    'level' => MonologLevel::Debug,
    'file_permission' => 0775,
];

// JWT
$settings['jwt'] = [

    // The issuer name
    'issuer' => 'tdw-upm',

    // OAuth2: client-id
    'client-id' => 'upm-tdw-aciencia',

    // Max lifetime in seconds
    'lifetime' => 14400,

    // The private key file
    'private_key_file' => __DIR__ . '/private.pem',

    // The public key file
    'public_key_file' => __DIR__ . '/public.pem',
];

// Load environment configuration
//if (file_exists(__DIR__ . '/../../env.php')) {
//    require __DIR__ . '/../../env.php';
//} elseif (file_exists(__DIR__ . '/env.php')) {
//    require __DIR__ . '/env.php';
//}

// Unit-test and integration environment (Travis CI)
//if (defined('APP_ENV')) {
//    require __DIR__ . basename(APP_ENV) . '.php';
//}
// Database (Doctrine) settings
$settings['doctrine'] = [
    'meta' => [
        'entity_path' => [__DIR__ . '/../src/Entity'],
        'auto_generate_proxies' => true,
        'proxy_dir' => __DIR__ . '/../var/doctrine/proxies',
        'cache' => null,
    ],
    'connection' => [
        'driver'   => getenv('DATABASE_DRIVER'),
        'host'     => getenv('DATABASE_HOST'),
        'port'     => getenv('DATABASE_PORT'),
        'dbname'   => getenv('DATABASE_NAME'),
        'user'     => getenv('DATABASE_USER'),
        'password' => getenv('DATABASE_PASSWD'),
        'charset'  => getenv('DATABASE_CHARSET'),
    ]
];

return $settings;
