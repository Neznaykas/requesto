<?php

namespace Tests;

use Drom\ApiException;
use Drom\CommentsClient;
use Drom\Model\CommentDto;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Laminas\Diactoros\StreamFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class CommentsClientTest extends TestCase
{
    public const GET_COMMENTS = 'comments';
    public const ADD_COMMENT = 'comment';
    public const UPDATE_COMMENT = 'comment/';

    private MockHandler $mockHandler;
    private CommentsClient $client;

    public function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        $handlerStack = HandlerStack::create($this->mockHandler);

        $httpClient = new Client(['handler' => $handlerStack, RequestOptions::HTTP_ERRORS => false]);
        $this->client = new CommentsClient(new HttpFactory(), new StreamFactory(), $httpClient);
    }

    public static function commentDataProvider(): array
    {
        return [
            [['id' => 1, 'name' => 'Dromer', 'text' => 'test_1']],
            [['id' => 2, 'name' => 'John', 'text' => 'test_2']],
        ];
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     * @dataProvider commentDataProvider
     */
    public function testGetComments($commentData): void
    {
        $expected = [
            'status' => 'success',
            'data' => [$commentData],
        ];

        $this->mockHandler->append(new Response(200, [], json_encode($expected)));
        $comments = $this->client->getComments(self::GET_COMMENTS);

        self::assertEquals($expected['data'][0]['id'], $comments[0]->getId());
        self::assertEquals($expected['data'][0]['text'], $comments[0]->getText());
        self::assertEquals($expected['data'][0]['name'], $comments[0]->getName());
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     * @dataProvider commentDataProvider
     */
    public function testAddComment($commentData): void
    {
        $json = [
            'status' => 'success',
            'data' => [$commentData],
        ];

        $comment = new CommentDto($commentData['id'], $commentData['name'], $commentData['text']);

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $addedComment = $this->client->addComment($comment, self::ADD_COMMENT);

        self::assertObjectEquals($comment, $addedComment);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     * @dataProvider commentDataProvider
     */
    public function testUpdateComment($commentData): void
    {
        $json = [
            'status' => 'success',
            'data' => [$commentData],
        ];

        $comment = new CommentDto($commentData['id'], $commentData['name'], $commentData['text']);

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $updatedComment = $this->client->updateComment($comment, self::UPDATE_COMMENT);

        self::assertObjectEquals($comment, $updatedComment);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function testValidateResponseException(): void
    {
        self::expectException(ApiException::class);
        self::expectExceptionCode(0);

        $this->mockHandler->append(new Response(500));
        $this->client->getComments(self::GET_COMMENTS);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function testNoDataResponseException(): void
    {
        self::expectException(ApiException::class);
        self::expectExceptionMessageMatches('/No data in response/');
        self::expectExceptionCode(0);

        $json = [
            'status' => 'success',
            'data' => [],
        ];

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $this->client->getComments(self::GET_COMMENTS);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function testValidateModelResponseException(): void
    {
        self::expectException(ApiException::class);
        self::expectExceptionMessageMatches('/Invalid comment model schema: /');
        self::expectExceptionCode(0);

        $json = [
            'status' => 'success',
            'data' => [['id' => 2, 'name12' => 'John', 'texttest_2']],
        ];

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $this->client->getComments(self::GET_COMMENTS);
    }
}
