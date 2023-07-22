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
    'mariadb' => []
];