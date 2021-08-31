<?php

declare(strict_types=1);

namespace Docufiy\Actions\User;

use Docufiy\Actions\BaseAction;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Docufiy\Domain\Services\User\UserService;
use Docufiy\Responders\User\UserResponder;

final class UserAction extends BaseAction
{

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