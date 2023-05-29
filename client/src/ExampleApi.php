<?php

namespace Drom;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ExampleApi
{
    private RequestFactoryInterface $requestFactory;
    private StreamInterface $stream;
    private ClientInterface $httpClient;
    private string $baseUrl;

    public function __construct(
        RequestFactoryInterface $requestFactory,
        StreamInterface $stream,
        ClientInterface $httpClient,
        string $baseUrl
    ) {
        $this->requestFactory = $requestFactory;
        $this->stream = $stream;
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
    }

    public function get(string $url): ResponseInterface
    {
        $request = $this->requestFactory->createRequest('GET', $this->baseUrl . $url)
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

    public function post(string $url, array $data): ResponseInterface
    {
        $this->stream->write(json_encode($data));

        $request = $this->requestFactory->createRequest('POST', $this->baseUrl . $url)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream);

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

    public function put(string $url, array $data): ResponseInterface
    {
        $this->stream->write(json_encode($data));

        $request = $this->requestFactory->createRequest('PUT', $this->baseUrl . $url)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream);

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
