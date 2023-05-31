<?php

namespace Drom;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ExampleApi
{
    private RequestFactoryInterface $requestFactory;
    private StreamInterface $stream;
    private ClientInterface $httpClient;

    public function __construct(
        RequestFactoryInterface $requestFactory,
        StreamInterface $stream,
        ?ClientInterface $httpClient
    ) {
        $this->requestFactory = $requestFactory;
        $this->stream = $stream;

        $config = [
            'base_uri' => 'https://example.com',
        ];

        $this->httpClient = $httpClient ?? new Client($config);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function make(RequestInterface $request): ResponseInterface
    {
        $this->handleResponse(
            $response = $this->httpClient->sendRequest($request)
        );

        return $response;
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getComments(string $url = 'comments ')
    {
        $request = $this->requestFactory->createRequest('GET', $url)
            ->withHeader('Content-Type', 'application/json');

        $response = $this->make($request);
        return json_decode($response->getBody(), true);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function addComment(array $comment, string $url = 'comment')
    {
        $this->stream->write(json_encode($comment));

        $request = $this->requestFactory->createRequest('POST', $url)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream);

        $response = $this->make($request);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function updateComment(int $id, array $comment, string $url = 'comment/')
    {
        $this->stream->write(json_encode($comment));

        $request = $this->requestFactory->createRequest('PUT', $url . $id)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream);

        $response = $this->make($request);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws ClientExceptionInterface
     */
    private function handleResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() !== 200) {
            throw new ApiException("Response status code {$response->getStatusCode()}", $response);
        }

        try {
            $json = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new ApiException("Invalid json schema.", $response);
        }

        /*if ($json['status'] === 'failed') {
            throw new ApiException("Response status is failed.", $response);
        }*/

    }
}
