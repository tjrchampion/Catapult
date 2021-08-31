<?php

declare(strict_types=1);

namespace Docufiy\Domain\Services\User;

use Docufiy\Domain\Repositories\Implementations\UserRepositoryImpl;

class UserService
{

    /**
     * Should be UserImterface
	 * @var UserRepositoryImpl
	 */
	private $user;

    public function __construct(UserRepositoryImpl $user)
    {
        $this->user = $user;
    }
    /**
     * service wrapper to return the respository
     *
     * @return array
     */
    public function handle()
    {
        return $this->user->get();
    }
}
