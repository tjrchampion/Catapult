<?php

declare(strict_types=1);

namespace Catapult\Actions;

use Laminas\Diactoros\Response;
class BaseAction
{
    protected ?Response $response = NULL;

    public function __construct()
    {
        $this->response = $this->response();
    }

    /**
     * Implement response.
     * Here we don't want to have to spin up a new instance of Response every time,
     * rather call the ResponseInterface with Autowriting.
     *
     * @return Object
     */
    public function response()
    {
        return new Response;
    }

}