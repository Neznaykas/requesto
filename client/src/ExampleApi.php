<?php

namespace Drom;

use Psr\Http\Client\ClientExceptionInterface;
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

    /**
     * @throws ClientExceptionInterface
     * @throws ApiException
     */
    public function get(string $url): ResponseInterface
    {
        $request = $this->requestFactory->createRequest('GET', $this->baseUrl . $url)
            ->withHeader('Content-Type', 'application/json');

        $this->handleResponse(
            $response = $this->httpClient->sendRequest($request)
        );

        return $response;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ApiException
     */
    public function post(string $url, array $data): ResponseInterface
    {
        $this->stream->write(json_encode($data));

        $request = $this->requestFactory->createRequest('POST', $this->baseUrl . $url)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream);


        $this->handleResponse(
            $response = $this->httpClient->sendRequest($request)
        );

        return $response;
    }

    /**
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function put(string $url, array $data): ResponseInterface
    {
        $this->stream->write(json_encode($data));

        $request = $this->requestFactory->createRequest('PUT', $this->baseUrl . $url)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream);

        $this->handleResponse(
            $response = $this->httpClient->sendRequest($request)
        );

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

    /**
     * @throws ApiException
     */
    private function handleResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() !== 200) {
            throw new ApiException("Response status code is not 200 OK", $response);
        }

        try {
            $json = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new ApiException("Invalid json schema.", $response);
        }

        if ($json['status'] === 'failed') {
            throw new ApiException("Response status is failed.", $response);
        }

    }
}
