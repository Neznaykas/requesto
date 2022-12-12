<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Drom\ExampleApi;

class ExampleApiTest extends TestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = new ExampleApi();
    }

    public function tearDown(): void {
        $this->client = null;
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

    public function testUpdateComment()
    {
        $params = ['firstName' => 'qwest'];

        $response = $this->client->updateComment($params);

        //$this->assertEquals(200, $this->client->getStatusCode());
        $this->assertNotEmpty($response);

        $data = json_decode($response, true);
        $this->assertArrayHasKey('firstName', $data);
    }

}
