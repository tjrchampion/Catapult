<?php 

declare(strict_types=1);

use Catapult\Actions\User\UserAction;
use Catapult\Actions\Auth\AuthStoreAction;

$router->map('GET', '/users', $container->get(UserAction::class));
$router->map('POST', '/auth', $container->get(AuthStoreAction::class));