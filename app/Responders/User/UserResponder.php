<?php

declare(strict_types=1);

namespace Docufiy\Responders\User;

use Docufiy\Responders\BaseResponder;
use Psr\Http\Message\ResponseInterface;

class UserResponder extends BaseResponder
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