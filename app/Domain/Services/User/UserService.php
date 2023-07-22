<?php

declare(strict_types=1);

namespace Catapult\Domain\Services\User;

use Catapult\Domain\Repositories\Contracts\UserInterface;
class UserService
{
    /**
	 * @var UserInterface
	 */
	private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }
    /**
     * service wrapper to return the respository
     * //here you can manipulate the data and pass it into the repo
     * @return array
     */
    public function handle()
    {
        return $this->user->get();
    }
}
