<?php 

declare(strict_types=1);

use Dotenv\Dotenv;
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

$request = $container->get('request');

$responseFactory = new Laminas\Diactoros\ResponseFactory();
$strategy = new League\Route\Strategy\JsonStrategy($responseFactory);
$router   = (new League\Route\Router)->setStrategy($strategy);

/**
 * Routing
 */
require_once(__DIR__ . '/../routes/api.php');

$response = $router->dispatch($request);