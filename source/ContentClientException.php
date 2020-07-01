<?php

namespace GameMakerAcademy\GhostApi;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class ContentClientException extends RuntimeException
{
    protected $response;

    public function setGuzzleResponse(ResponseInterface $response): static
    {
        $this->response = $response;
        return $this;
    }

    public function getGuzzleResponse(): ResponseInterface
    {
        return $this->response;
    }
}
