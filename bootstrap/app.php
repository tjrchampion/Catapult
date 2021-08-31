<?php

use Docufiy\Actions\Home\HomeAction;
use Dotenv\Dotenv;
use League\Route\Router;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ResponseFactory;
use League\Route\Strategy\JsonStrategy;
use League\Container\ReflectionContainer;
use Dotenv\Exception\InvalidPathException;

/**
 * Require composer psr-4 autoload 
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Load dotenv file
 * Get env using $_ENV['BASE_URL'] not "getenv" as it is unsecure
 */
try {
    Dotenv::createImmutable(__DIR__ . '/..//')->load();
} catch(InvalidPathException $e) {
    throw new Error('Could not get environment file');
}

/**
 * Load Container
 */
require_once __DIR__ . '/container.php';

$responseFactory = new ResponseFactory();

$strategy = new JsonStrategy($responseFactory);
$route = $container->get('router')->setStrategy($strategy);


require_once(__DIR__ . '/../routes/api.php');


/**
 * Dispatch the request, and response to the route collection.
 */
$response = $route->dispatch(
    $container->get('request')
);