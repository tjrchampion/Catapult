<?php

declare(strict_types=1);

namespace Docufiy\Responders;

class BaseResponder
{

	public function withJson($response, array $data, int $status = 200)
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