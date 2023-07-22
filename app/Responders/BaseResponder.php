<?php

declare(strict_types=1);

namespace Catapult\Responders;

use Psr\Http\Message\ResponseInterface;

class BaseResponder
{
	public function withJson(ResponseInterface $response, array $data, int $status = 200)
	{
		$response->getBody()->write(
			json_encode([
				'success' => ($status >= 400) ? false : true,
				'data' => $data
			])
		);

		return $response->withHeader(
			'Content-Type', 'application/json'
		)->withStatus($status);
	}

}