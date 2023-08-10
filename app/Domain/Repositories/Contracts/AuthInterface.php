<?php

declare(strict_types=1);

namespace Catapult\Domain\Repositories\Contracts;

use Catapult\Domain\Models\User;
use Catapult\Exceptions\NotFoundException;

interface AuthInterface
{
    /**
     * getToken interface 
     *
     * @return Object
     */
    public function getToken(int $uId) : string;

    /**
     * saveToken interface 
     *
     * @return Object
     */
    public function saveToken($data);

    /**
     * is given password & email valid
     *
     * @return void
     */
    public function check(object $user): User|array;
}