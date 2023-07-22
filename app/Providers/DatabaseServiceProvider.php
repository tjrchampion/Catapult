<?php

declare(strict_types=1);

namespace Catapult\Providers;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
class DatabaseServiceProvider extends AbstractServiceProvider
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
            EntityManager::class
        ];
        return in_array($id, $services);
    }
    
    /**
     * Register Doctrine ORM into the container,
     * Note issue: https://github.com/doctrine/orm/issues/8809
     * Only thing that fixes this is to downgrade, so we're using an older version
     *
     * @return void
     */
    public function register(): void
    {
        $container = $this->getContainer();

        $config = $container->get('config');

        $container->add(EntityManager::class, function() use ($config) {
            $proxyDir = null;
            $cache = null;
            $useSimpleAnnotationReader = false;

            $entityManager = EntityManager::create(
                $config->get('mysql'),
                Setup::createAnnotationMetadataConfiguration(
                    [base_path('app')],
                    (bool) $config->get('app.debug'),
                    $proxyDir, $cache, $useSimpleAnnotationReader
                )
            );
            return $entityManager;

        });



    }

}