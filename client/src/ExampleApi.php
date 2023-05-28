<?php

namespace Drom;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class ExampleApi
{
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private ClientInterface $httpClient;

    public function __construct(
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        ClientInterface $httpClient
    ) {
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->httpClient = $httpClient;
    }

    public function get(string $url): ResponseInterface
    {
        $request = $this->requestFactory->createRequest('GET', $url)
            ->withHeader('Content-Type', 'application/json');

        $response = $this->httpClient->sendRequest($request);
        $statusCode = $response->getStatusCode();

        if ($statusCode > 500) {
            throw new ServiceUnavailableException();
        }

        if ($statusCode === 500) {
            throw new ServerErrorException();
        }

        if ($statusCode >= 400) {
            throw new ClientException();
        }

        return $response;
    }

    public function post(array $thing): ResponseInterface
    {
        $body = $this->streamFactory->createStream(json_encode($thing));
        $request = $this->requestFactory->createRequest('POST', 'https://api.myservice.com/things')
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);

        $response = $this->httpClient->sendRequest($request);
        $statusCode = $response->getStatusCode();

        if ($statusCode > 500) {
            throw new ServiceUnavailableException();
        }

        if ($statusCode === 500) {
            throw new ServerErrorException();
        }

        if ($statusCode >= 400) {
            throw new ClientException();
        }

        return $response;
    }

    public function getComments()
    {
        $response = $this->get('/comments');
        return json_decode($response->getBody(), true);
    }

    public function addComment($comment)
    {
        $response = $this->post('/comment', $comment);
        return json_decode($response->getBody(), true);
    }

    public function updateComment($id, $comment)
    {
        $response = $this->put('/comment/'.$id, $comment);
        return json_decode($response->getBody(), true);
    }

    public function addCommentWithConfirmation($comment)
    {
        $response = $this->post('/comment', $comment);
        $statusCode = $response->getStatusCode();
        if ($statusCode === 201) {
            return json_decode($response->getBody(), true);
        } else {
            return false;
        }
    }

}
