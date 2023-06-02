<?php

namespace Tests;

use Drom\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;
use Drom\ExampleApi;
use Psr\Http\Client\ClientExceptionInterface;
use PHPUnit\Framework\Attributes\DataProvider;

class ExampleApiTest extends TestCase
{
    private MockHandler $mockHandler;
    private ExampleApi $client;

    public function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        $handlerStack = HandlerStack::create($this->mockHandler);

        $stream = Psr7\Utils::streamFor('');
        $httClient = new Client(['handler' => $handlerStack, RequestOptions::HTTP_ERRORS => false]);

        $this->client = new ExampleApi(new HttpFactory(), $stream, $httClient);
    }

    /**
     * @throws ClientExceptionInterface
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
        $this->assertNotEmpty($response);
    }

    /**
     * @throws ClientExceptionInterface
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

        $this->assertArrayHasKey('id', $response['data'][0]);
    }

    /**
     * @throws ClientExceptionInterface
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

        $this->assertNotEmpty($response);

        $this->assertArrayHasKey('name', $response['data']);
        $this->assertArrayHasKey('text', $response['data']);

        $this->assertEquals('Dromer', $response['data']['name']);
    }

    #[DataProvider('responsesForTriggerException')]
    public function testHandleResponseException(\Closure $closure)
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(0);
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

