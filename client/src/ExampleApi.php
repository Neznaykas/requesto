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
        StreamFactoryInterface  $stream,
        ClientInterface         $httpClient
    )
    {
        $this->requestFactory = $requestFactory;
        $this->stream = $stream;
        $this->httpClient = $httpClient;
    }

    /**
     * @return Comment[]
     * @throws ApiException|ClientExceptionInterface
     */
    public function getComments(string $url = 'comments '): array
    {
        $request = $this->requestFactory->createRequest('GET', $url)
            ->withHeader('Content-Type', 'application/json');

        $comments = $this->handleResponse(
            $this->httpClient->sendRequest($request)
        );

        return array_map(static function ($commentData) {
            return new Comment(
                $commentData->id,
                $commentData->name,
                $commentData->text
            );
        }, $comments);
    }

    /**
     * @param Comment $comment
     * @param string $url
     * @return Comment
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function addComment(Comment $comment, string $url = 'comment'): Comment
    {
        $request = $this->requestFactory->createRequest('POST', $url)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream->createStream($comment->toJson()));

        $added = $this->handleResponse(
            $this->httpClient->sendRequest($request)
        )[0];

        return new Comment($added->id, $added->name, $added->text);
    }

    /**
     * @param Comment $comment
     * @param string $url
     * @return Comment
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function updateComment(Comment $comment, string $url = 'comment/'): Comment
    {
        $request = $this->requestFactory->createRequest('PUT', $url . $comment->getId())
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->stream->createStream($comment->toJson()));

        $updated = $this->handleResponse(
            $this->httpClient->sendRequest($request)
        )[0];

        $comment->setName($updated->name);
        $comment->setText($updated->text);

        return $comment;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws ApiException
     */
    private function handleResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new ApiException("Response status code {$statusCode}", $response);
        }

        try {
            $body = $response->getBody()->getContents();
            $json = json_decode($body, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new ApiException("Invalid json schema.", $response);
        }

        if (!is_array($json->data) || count($json->data) === 0) {
            throw new ApiException("No data model.", $response);
        }

        $comment = $json->data[0];
        if (!isset($comment->id, $comment->name, $comment->text)) {
            throw new ApiException("Invalid client model schema. " . json_encode($comment), $response);
        }

        return $json->data;
    }
}
