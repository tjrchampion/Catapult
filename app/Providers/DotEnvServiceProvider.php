<?php

declare(strict_types=1);

namespace Catapult\Providers;

use Dotenv\Dotenv;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DotEnvServiceProvider extends AbstractServiceProvider
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
            'dotenv'
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

        $container->add('dotenv', function() {
            if(file_exists(__DIR__ . '/../../.env')) {
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
                $dotenv->load();
            }
        });
    }

}