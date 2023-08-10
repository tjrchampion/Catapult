<?php

return [
    'mysql' => [
        'driver' => $_ENV['DB_DRIVER'],
        'host' => $_ENV['DB_HOST'],
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'port' => $_ENV['DB_PORT'],
        'password' => $_ENV['DB_PASS'],
    ],
    'redis' => [
        'cluster' => false,
        'default' => [
            'schema' => $_ENV['REDIS_SCHEMA'],
            'host' => $_ENV['REDIS_HOST'],
            'port' => $_ENV['REDIS_PORT'],
            'password' => $_ENV['REDIS_PASSWORD'],
        ]
    ],
    'mariadb' => [],
];