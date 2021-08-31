<?php

use Docufiy\Actions\User\UserAction;


$route->get('/', $container->get(UserAction::class))->setName('user');