<?php

namespace Drom;

use Drom\Model\CommentDto;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class CommentsClient
{
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $stream;
    private ClientInterface $httpClient;

    public function __construct(
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface  $stream,
        ClientInterface         $httpClient,
    ) {
        $this->requestFactory = $requestFactory;
        $this->stream = $stream;
        $this->httpClient = $httpClient;
    }

    /**
     * @return CommentDto[]
     * @throws ApiException|ClientExceptionInterface
     */
    public function getComments(string $url): array
    {
        $request = $this->requestFactory->createRequest('GET', $url)
            ->withHeader('Content-Type', 'application/json')
        ;

        $response = $this->httpClient->sendRequest($request);

        return $this->validateResponse($response);
    }

    /**
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function addComment(CommentDto $comment, string $url): CommentDto
    {
        $request = $this->requestFactory->createRequest('POST', $url)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream->createStream($comment->toJson()))
        ;

        $response = $this->httpClient->sendRequest($request);

        return $this->validateResponse($response)[0];
    }

    /**
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function updateComment(CommentDto $comment, string $url): CommentDto
    {
        $request = $this->requestFactory->createRequest('PUT', $url . $comment->getId())
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream->createStream($comment->toJson()))
        ;

        $response = $this->httpClient->sendRequest($request);

        return $this->validateResponse($response)[0];
    }

    /**
     * @return CommentDto[]
     * @throws ApiException
     */
    private function validateResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new ApiException("Response status code {$statusCode}", $response);
        }

        try {
            $body = $response->getBody()->getContents();
            $json = json_decode($body, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new ApiException("Invalid json schema. {$e->getMessage()}", $response);
        }

        if (!is_array($json->data) || count($json->data) === 0) {
            throw new ApiException("No data in response", $response);
        }

        return array_map(static function ($commentData) use ($response) {
            if (!isset($commentData->id, $commentData->name, $commentData->text)) {
                throw new ApiException("Invalid comment model schema: " . json_encode($commentData), $response);
            }

            return new CommentDto(
                $commentData->id,
                $commentData->name,
                $commentData->text,
            );
        }, $json->data);
    }
}
