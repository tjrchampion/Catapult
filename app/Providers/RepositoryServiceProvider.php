<?php

declare(strict_types=1);

namespace Catapult\Providers;

use Doctrine\ORM\EntityManager;
use Catapult\Domain\Repositories\Contracts\AuthInterface;
use Catapult\Domain\Repositories\Contracts\UserInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Catapult\Domain\Repositories\Implementations\AuthRepositoryImpl;
use Catapult\Domain\Repositories\Implementations\UserRepositoryImpl;
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
            UserInterface::class,
            AuthInterface::class,
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
        $config = $container->get('config');

        $container->add(UserInterface::class, function() use ($container) {
            return new UserRepositoryImpl(
                $container->get(EntityManager::class),
                $container->get('redis'),
            );
        });
        
        $container->add(AuthInterface::class, function() use ($container) {
            return new AuthRepositoryImpl(
                $container->get(EntityManager::class), $container->get('config')
            );
        });
    }

}