<?php

declare(strict_types=1);

namespace Catapult\Actions\User;

use Catapult\Actions\BaseAction;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Catapult\Responders\User\UserResponder;
use Catapult\Domain\Services\User\UserService;
final class UserAction extends BaseAction
{

    private $service;

    private $responder;

    public function __construct(UserService $service, UserResponder $responder)
    {
        parent::__construct();
        $this->service = $service;
        $this->responder = $responder;
    }

    /**
	 * @param RequestInterface $request
	 * @return ResponseInterface
	 */
    public function __invoke(RequestInterface $request)
    {
        return $this->responder->send(
            $this->response, $this->service->handle() //can pass in your request object if needed.
        );
    }
}