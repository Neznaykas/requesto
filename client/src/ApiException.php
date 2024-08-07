<?php

namespace Drom;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

class ApiException extends \Exception implements ClientExceptionInterface
{
    public function __construct(string $message, private readonly ResponseInterface $response)
    {
        parent::__construct($message);
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
