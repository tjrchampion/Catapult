<?php

declare(strict_types=1);

use League\Container\Container;
use League\Container\ReflectionContainer;

use Docufiy\Providers\ {
    AppServiceProvider,
    DotEnvServiceProvider,
    RepositoryServiceProvider,
    ConfigServiceProvider,
    DatabaseServiceProvider
};

$container = new Container();

/**
 * Custom Docufiy Container
 * //use Docufiy\Container\Container;
 */
// $container->share('router', function($container) {
//     return new Router();
// });
// $container->share('request', function() {
//     return ServerRequestFactory::fromGlobals([
//         $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
//     ]);
// });
// $container->share('emitter', function($container) {
//     return new SapiStreamEmitter();
// });

/**
 * Enable Autowiring on our Leauge Container
 */
$container->delegate(
    new ReflectionContainer()
);

/**
 * Inject Service Providers into our Leauge Container
*/
$container->addServiceProvider(new AppServiceProvider());
$container->addServiceProvider(new ConfigServiceProvider());
$container->addServiceProvider(new DotEnvServiceProvider());
$container->addServiceProvider(new RepositoryServiceProvider());
$container->addServiceProvider(new DatabaseServiceProvider());