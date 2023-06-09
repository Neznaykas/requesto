<?php

namespace Drom;

use Drom\Model\Comment;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
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
     * @return Comment[]
     */
    public function getComments(string $url = 'comments '): array
    {
        $request = $this->requestFactory->createRequest('GET', $url)
            ->withHeader('Content-Type', 'application/json');

        $comments = $this->handleResponse(
            $this->httpClient->sendRequest($request)
        );

        return array_map(static function ($commentData) {
            if (isset($commentData['id'], $commentData['name'], $commentData['text'])) {
                return new Comment(
                    $commentData['id'],
                    $commentData['name'],
                    $commentData['text']
                );
            }
            return $commentData;
        }, $comments);
    }

    /**
     * @param array $comment
     * @param string $url
     * @return Comment|array
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function addComment(array $comment, string $url = 'comment'): Comment|array
    {
        $request = $this->requestFactory->createRequest('POST', $url)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream->createStream(json_encode($comment)));

        $comment = $this->handleResponse(
            $this->httpClient->sendRequest($request)
        );

        return isset($comment['id'], $comment['name'], $comment['text'])
            ? new Comment($comment['id'], $comment['name'], $comment['text']) : $comment;
    }

    /**
     * @param string $id
     * @param array $comment
     * @param string $url
     * @return Comment|array
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function updateComment(string $id, array $comment, string $url = 'comment/'): Comment|array
    {
        $request = $this->requestFactory->createRequest('PUT', $url . $id)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream->createStream(json_encode($comment)));

        $comment = $this->handleResponse(
            $this->httpClient->sendRequest($request)
        );

        return isset($comment['id'], $comment['name'], $comment['text'])
        ? new Comment($comment['id'], $comment['name'], $comment['text']) : $comment;
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    private function handleResponse(ResponseInterface $response): mixed
    {
        if ($response->getStatusCode() !== 200) {
            throw new ApiException("Response status code {$response->getStatusCode()}", $response);
        }

        try {
            $json = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new ApiException("Invalid json schema.", $response);
        }

        return $json['data'] ?? $json;
    }
}
