<?php

namespace Drom;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class ExampleApi
{
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $stream;
    private ClientInterface $httpClient;

    public function __construct(
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $stream,
        ClientInterface $httpClient
    ) {
        $this->requestFactory = $requestFactory;
        $this->stream = $stream;
        $this->httpClient = $httpClient;
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    private function executeRequest(RequestInterface $request): ResponseInterface
    {
         $this->validateResponse(
            $response = $this->httpClient->sendRequest($request)
        );

        return $response;
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function getComments(string $url = 'comments ')
    {
        $request = $this->requestFactory->createRequest('GET', $url)
            ->withHeader('Content-Type', 'application/json');

        $response = $this->executeRequest($request);
        return json_decode($response->getBody(), true);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function addComment(array $comment, string $url = 'comment')
    {
        $request = $this->requestFactory->createRequest('POST', $url)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream->createStream(json_encode($comment)));

        $response = $this->executeRequest($request);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function updateComment(string $id, array $comment, string $url = 'comment/')
    {
        $request = $this->requestFactory->createRequest('PUT', $url . $id)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream->createStream(json_encode($comment)));

        $response = $this->executeRequest($request);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    private function validateResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() === 418)
            throw new ApiException("Sorry, It's teapot", $response);

        if ($response->getStatusCode() !== 200) {
            throw new ApiException("Response status code {$response->getStatusCode()}", $response);
        }

        try {
            $json = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            $status = $json['status'] ?? false;

            if ($status === 'failed') {
                throw new ApiException("Response status failed.", $response);
            }
        } catch (\JsonException) {
            throw new ApiException("Invalid json schema.", $response);
        }

    }
}
