<?php

declare(strict_types=1);

use League\Container\Container;
use League\Container\ReflectionContainer;
use Catapult\Providers\ConfigServiceProvider;

$container = new Container();

/**
 * Enable Autowiring on our Leauge Container
 */
$container->delegate(
    new ReflectionContainer()
);

/**
 * Inject Service Providers into our Leauge Container
*/
$container->addServiceProvider(new ConfigServiceProvider());

foreach($container->get('config')->get('providers') as $provider) {
    $container->addServiceProvider(new $provider);
}