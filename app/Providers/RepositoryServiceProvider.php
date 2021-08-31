<?php

declare(strict_types=1);

namespace Docufiy\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Docufiy\Domain\Repositories\Contracts\HomeInterface;
use Docufiy\Domain\Repositories\Implementations\HomeRepositoryImpl;

class RepositoryServiceProvider extends AbstractServiceProvider
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
            HomeInterface::class
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

        $container->add(HomeInterface::class, function () {
            return new HomeRepositoryImpl();
        });
    }

}