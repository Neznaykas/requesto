<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7;
use PHPUnit\Framework\TestCase;
use Drom\ExampleApi;

class ExampleAPITest extends TestCase
{
    private ExampleApi $client;
    private string $url = 'https://dummyapi.io/data/v1/';

    public function setUp(): void
    {
        $client = new Client();
        $stream = Psr7\Utils::streamFor('');

        $this->client = new ExampleApi(new HttpFactory(), $stream, $client, $this->url);
    }

    public function testGetComments()
    {
        $response = $this->client->getComments();
        //403 Forbidden 
        //$this->assertEquals(403, $this->client->getStatusCode());

        $this->assertNotEmpty($response);
    }

    public function testAddComment()
    {
        $params = [
            'message' => 'qwest',
            'owner' => '60d0fe4f5311236168a109d0',
            'post' => '60d21b7967d0d8992e610d1b'
        ];

        $response = $this->client->addComment($params);

        //200 OK
        //$this->assertEquals(200, $this->client->getStatusCode());
        $this->assertNotEmpty($response);
    }

    public function testUpdateComment1()
    {
        $params = ['firstName' => 'qwest'];

        $response = $this->client->updateComment($params);

        //$this->assertEquals(200, $this->client->getStatusCode());
        $this->assertNotEmpty($response);

        $data = json_decode($response, true);
        $this->assertArrayHasKey('firstName', $data);
    }

    public function testAddComment1()
    {
        $comment = [
            'name' => 'John',
            'email' => 'john@example.com',
            'body' => 'This is a test comment'
        ];
        $response = $this->client->addComment($comment);
        $this->assertArrayHasKey('id', $response);
    }

    public function testUpdateComment()
    {
        $comment = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'body' => 'This is an updated comment'
        ];
        $response = $this->client->updateComment(1, $comment);
        $this->assertEquals('John Doe', $response['name']);
    }

    public function testAddCommentWithConfirmation()
    {
        $comment = [
            'name' => 'Jane',
            'email' => 'jane@example.com',
            'body' => 'This is a test comment'
        ];
        $response = $this->client->addCommentWithConfirmation($comment);
        $this->assertNotEquals(false, $response);
    }

}
