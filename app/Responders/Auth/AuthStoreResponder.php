<?php

declare(strict_types=1);

namespace Catapult\Responders\Auth;

use Catapult\Responders\BaseResponder;
use Psr\Http\Message\ResponseInterface;

class AuthStoreResponder extends BaseResponder
{
    /**
     *
     * @param ResponseInterface $response
     * @param array $data
     * @return void
     */
    public function send(ResponseInterface $response, array $data = null)
    {
        return $this->withJson($response, $data, 200);
    }
}