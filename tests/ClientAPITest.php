<?php

use PHPUnit\Framework\TestCase;
use Drom\Client;

const BASE_URL = 'https://dummyapi.io/data/v1/';
const APP_ID = '617b11efbdaa719034cf6d83';

const POST_COMMENT = BASE_URL . 'comment/create';
const GET_USERS = BASE_URL . 'user';
const PUT_USER = BASE_URL . 'user/60d0fe4f5311236168a109ca';

class ClientAPITest extends TestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = new Client;
    }

    public function tearDown(): void {
        $this->client = null;
    }

    public function testGetWithNoHeaders()
    {
        $response = $this->client->get(GET_USERS);
        //403 Forbidden 
        $this->assertEquals(403, $this->client->getStatusCode());

        $this->assertEquals('{"error":"APP_ID_MISSING"}', $response);
    }

    public function testGetWithHeaders()
    {
        $response = $this->client->get(GET_USERS, ['app-id: ' . APP_ID]);

        $this->assertEquals(200, $this->client->getStatusCode());

        $this->assertNotEmpty($response);
    }

    public function testPostWithHeaders()
    {
        $params = [
            'message' => 'qwest',
            'owner' => '60d0fe4f5311236168a109d0',
            'post' => '60d21b7967d0d8992e610d1b'
        ];

        $response = $this->client->post(POST_COMMENT, ['app-id: ' . APP_ID], $params);
        //200 OK
        $this->assertEquals(200, $this->client->getStatusCode());
        $this->assertNotEmpty($response);
    }

    public function testPostWithoutParams()
    {
        $response = $this->client->post(POST_COMMENT, ['app-id: ' . APP_ID]);
        //400 Bad Request
        $this->assertEquals(400, $this->client->getStatusCode());
        
        $data = json_decode($response, true);
        $this->assertArrayHasKey('error', $data);

        $this->assertNotEmpty($response);
    }

    public function testPutWithHeaders()
    {
        $params = ['firstName' => 'qwest'];

        $response = $this->client->put(PUT_USER, ['app-id: ' . APP_ID], $params);

        $this->assertEquals(200, $this->client->getStatusCode());
        $this->assertNotEmpty($response);

        $data = json_decode($response, true);
        $this->assertArrayHasKey('firstName', $data);
    }
}

?>