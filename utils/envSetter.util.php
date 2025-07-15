<?php

// Define BASE_PATH only if not already defined
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../');
}

require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

return [
    'mongo' => [
        'uri' => isset($_ENV['MONGO_URI']) ? $_ENV['MONGO_URI'] : null,
        'db'  => isset($_ENV['MONGO_DB']) ? $_ENV['MONGO_DB'] : null,
    ],
    'postgres' => [
        'host'     => isset($_ENV['POSTGRES_HOST']) ? $_ENV['POSTGRES_HOST'] : null,
        'port'     => isset($_ENV['POSTGRES_PORT']) ? $_ENV['POSTGRES_PORT'] : null,
        'db'       => isset($_ENV['POSTGRES_DB']) ? $_ENV['POSTGRES_DB'] : null,
        'user'     => isset($_ENV['POSTGRES_USER']) ? $_ENV['POSTGRES_USER'] : null,
        'password' => isset($_ENV['POSTGRES_PASSWORD']) ? $_ENV['POSTGRES_PASSWORD'] : null,
    ],
];
