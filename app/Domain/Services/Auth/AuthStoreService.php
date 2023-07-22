<?php

namespace Catapult\Domain\Services\Auth;

use Catapult\Domain\Repositories\Contracts\AuthInterface;

class AuthStoreService
{
    /**
	 * @var AuthInterface
	 */
	private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }
    /**
     * service wrapper to return the respository
     * //here you can manipulate the data and pass it into the repo
     * @return array
     */
    public function handle($data)
    {
        return $this->auth->saveToken($data);
    }
}
