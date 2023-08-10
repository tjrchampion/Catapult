<?php declare(strict_types=1);

namespace Catapult\Actions\Auth;

use Catapult\Actions\BaseAction;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response;
use Catapult\Responders\Auth\AuthStoreResponder;
use Catapult\Domain\Services\Auth\AuthStoreService;

final class AuthStoreAction extends BaseAction
{
    protected ?Response $response;
    /**
     * Responder for Auth
     *
     * @var AuthStoreResponder
     */
    private $responder;

    /**
     * Service for Auth
     *
     * @var AuthStoreService
     */
    private $service;

    public function __construct(AuthStoreService $service, AuthStoreResponder $responder)
    {
        parent::__construct();
        $this->service = $service;
        $this->responder = $responder;
    }

    /**
	 * @param RequestInterface $request
	 * @return ResponseInterface
	 */
    public function __invoke(ServerRequest $request)
    {
		return $this->responder->send($this->response,
			$this->service->handle(
				$request->getBody()->getContents()
			)
		);
    }
}