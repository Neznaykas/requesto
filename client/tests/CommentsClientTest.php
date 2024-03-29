<?php

namespace Tests;

use Drom\ApiException;
use Drom\Model\Comment;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;
use Drom\CommentsClient;
use Psr\Http\Client\ClientExceptionInterface;
use Laminas\Diactoros\StreamFactory;


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
            [['id' => 2, 'name' => 'John', 'text' => 'test_2']]
        ];
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     * @dataProvider commentDataProvider
     */
    public function testGetComments($commentData)
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
    public function testAddComment($commentData)
    {
        $json = [
            'status' => 'success',
            'data' => [$commentData]
        ];

        $comment = new Comment($commentData['id'], $commentData['name'], $commentData['text']);

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $addedComment = $this->client->addComment($comment, self::ADD_COMMENT);

        self::assertObjectEquals($comment, $addedComment);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     * @dataProvider commentDataProvider
     */
    public function testUpdateComment($commentData)
    {
        $json = [
            'status' => 'success',
            'data' => [$commentData]
        ];

        $comment = new Comment($commentData['id'], $commentData['name'], $commentData['text']);

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $updatedComment = $this->client->updateComment($comment, self::UPDATE_COMMENT);

        self::assertObjectEquals($comment, $updatedComment);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function testValidateResponseException()
    {
        self::expectException(ApiException::class);
        self::expectExceptionCode(0);

        $this->mockHandler->append(new Response(500));
        $this->client->getComments(self::GET_COMMENTS);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function testNoDataResponseException()
    {
        self::expectException(ApiException::class);
        self::expectExceptionMessageMatches('/No data in response/');
        self::expectExceptionCode(0);

        $json = [
            'status' => 'success',
            'data' => []
        ];

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $this->client->getComments(self::GET_COMMENTS);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function testValidateModelResponseException()
    {
        self::expectException(ApiException::class);
        self::expectExceptionMessageMatches('/Invalid client model schema/');
        self::expectExceptionCode(0);

        $json = [
            'status' => 'success',
            'data' => [['id' => 2, 'name12' => 'John', 'texttest_2']]
        ];

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $this->client->getComments(self::GET_COMMENTS);
    }
}

