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
        $json = [
            'status' => 'success',
            'data' => [
                ['id' => 1, 'name' => 'test', 'text' => 'test'],
                ['id' => 2, 'name' => 'test', 'text' => 'test'],
            ]
        ];

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $response = $this->client->getComments();
        self::assertNotEmpty($response);
    }

    /**
     * @throws ApiException|ClientExceptionInterface
     */
    public function testAddComment()
    {
        $comment = [
            'name' => 'John',
            'email' => 'john@example.com',
            'body' => 'This is a test comment'
        ];

        $json = [
            'status' => 'success',
            'data' => [
                ['id' => 1, 'name' => 'test', 'text' => 'test'],
                ['id' => 2, 'name' => 'test', 'text' => 'test'],
            ]
        ];

        $this->mockHandler->append(new Response(200, [], json_encode($json)));
        $response = $this->client->addComment($comment);
        self::assertArrayHasKey('id', $response['data'][0]);
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
        $response = $this->client->updateComment(1, $comment);

        self::assertNotEmpty($response);

        self::assertArrayHasKey('name', $response['data']);
        self::assertArrayHasKey('text', $response['data']);

        self::assertEquals('Dromer', $response['data']['name']);
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
                    $this->mockHandler->append(new Response(418));
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

