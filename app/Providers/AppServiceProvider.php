<?php

declare(strict_types=1);

namespace Catapult\Providers;

use League\Route\Router;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AppServiceProvider extends AbstractServiceProvider
{
    
    /**
     * The provides method is a way to let the container
     * know that a service is provided by this service
     * provider.
     *
     * @param string $id
     * @return boolean
     */
    public function provides(string $id): bool
    {
        $services = [
            'router',
            'emitter',
            'request',
            'response'
        ];
        return in_array($id, $services);
    }
    
    /**
     * The register method is where you define services
     * in the same way you would directly with the container.
     *
     * @return void
     */
    public function register(): void
    {
        $container = $this->getContainer();
        
        $container->add('response', Response::class);

        $container->add('request', function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });

        $container->add('router', function() {
            return Router::class;
        });

        $container->add('emitter', SapiEmitter::class);
    }

}