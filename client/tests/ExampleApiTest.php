<?php

namespace Tests;

use Drom\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;
use Drom\ExampleApi;
use Psr\Http\Client\ClientExceptionInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Laminas\Diactoros\StreamFactory;

class ExampleApiTest extends TestCase
{
    private MockHandler $mockHandler;
    private ExampleApi $client;

    public function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        $handlerStack = HandlerStack::create($this->mockHandler);

        $httClient = new Client(['handler' => $handlerStack, RequestOptions::HTTP_ERRORS => false]);
        $this->client = new ExampleApi(new HttpFactory(), new StreamFactory(), $httClient);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function testGetComments()
    {
        $expected = [
            'status' => 'success',
            'data' => [['id' => 1, 'name' => 'test', 'text' => 'test'],
                      ['id' => 2, 'name' => 'test', 'text' => 'test']],
        ];

        $this->mockHandler->append(new Response(200, [], json_encode($expected)));
        $comments = $this->client->getComments();

        self::assertEquals($expected['data'][0]['id'], $comments[0]->getId());
        self::assertEquals($expected['data'][0]['text'], $comments[0]->getText());
        self::assertEquals($expected['data'][0]['name'], $comments[0]->getName());

        self::assertEquals($expected['data'][1]['id'], $comments[1]->getId());
        self::assertEquals($expected['data'][1]['text'], $comments[1]->getText());
        self::assertEquals($expected['data'][1]['name'], $comments[1]->getName());
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function testAddComment()
    {
        $expected = ['id' => 1, 'name' => 'test', 'text' => 'test'];
        $attributes = ['name' => 'test', 'text' => 'test'];

        $json = [
            'status' => 'success',
            'data' => $expected
        ];

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $comment = $this->client->addComment($attributes);

        self::assertEquals($expected['id'], $comment->getId());
        self::assertEquals($expected['text'], $comment->getText());
        self::assertEquals($expected['name'], $comment->getName());
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function testUpdateComment()
    {
        $comment = ['id' => 1, 'name' => 'test', 'text' => 'test'];
        $attributes = ['name' => 'Dromer', 'text' => 'test_1'];

        $json = [
            'status' => 'success',
            'data' => [...$comment, ...$attributes]
        ];

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $updatedComment = $this->client->updateComment(1, $comment);

        self::assertNotEmpty($updatedComment);
        self::assertEquals('Dromer', $updatedComment->getName());
        self::assertEquals('test_1', $updatedComment->getText());
    }

    #[DataProvider('responsesForTriggerException')]
    public function testHandleResponseException(\Closure $closure)
    {
        self::expectException(ApiException::class);
        self::expectExceptionCode(0);
        $closure->call($this);
    }

    public static function responsesForTriggerException(): array
    {
        return [
            [
                function (): void {
                    $this->mockHandler->append(new Response(418));
                    $this->client->getComments();
                }
            ],
            [
                function (): void {
                    $this->mockHandler->append(new Response(500));
                    $this->client->getComments();
                }
            ],
            [
                function (): void {
                    $json = [
                        'status' => 'failed',
                        'data' => []
                    ];
                    $this->mockHandler->append(new Response(200, [], json_encode($json)));
                    $this->client->getComments();
                }
            ]
        ];
    }
}

