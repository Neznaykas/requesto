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
        $comments = $this->client->getComments();

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
        $addedComment = $this->client->addComment($comment);

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
        $updatedComment = $this->client->updateComment($comment);

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
        $this->client->getComments();
    }
}

