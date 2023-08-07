<?php

return [
    'app' => [
        'name' => $_ENV['APP_NAME'],
        'base_url' => $_ENV['BASE_URL'],
        'debug' => $_ENV['APP_DEBUG']
    ],
    'providers' => [
        'Catapult\Providers\AppServiceProvider',
        'Catapult\Providers\DotEnvServiceProvider',
        'Catapult\Providers\DatabaseServiceProvider',
        'Catapult\Providers\RepositoryServiceProvider',
        'Catapult\Providers\RedisServiceProvider',
    ],
];