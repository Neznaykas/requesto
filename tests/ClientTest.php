<?php

include_once 'bootstrap.php';

use PHPUnit\Framework\TestCase;
use Drom\Client;
use Drom\ClientInterface;

const BASE_URL = 'https://dummyapi.io/data/v1/';
const COMMENTS_URL = 'comment/';
const APP_ID_VALUE = '617b11efbdaa719034cf6d83';

class ClientTest extends TestCase
{
    private $client;

    /**
     * @expectedException InvalidArgumentException
     */
    /*public function testException()
    {
        $this->expectException(InvalidArgumentException::class);
    }*/

    public function setUp(): void
    {
        $this->client = new Client;
    }

    public function tearDown(): void {
        $this->client = null;
    }

    public function testGetWithNoHeaders()
    {
        $response = $this->client->get('https://dummyapi.io/data/v1/');

        $this->assertEquals(200, $this->client->getStatusCode());
        $this->assertEquals('{"error":"APP_ID_MISSING"}', $response);
    }

    public function testGetWithHeaders()
    {
        $response = $this->client->get('https://dummyapi.io/data/v1/', ['app-id: ' . '']);

        $this->assertEquals(200, $this->client->getStatusCode());
        $this->assertEquals('{"error":"APP_ID_MISSING"}', $response);
    }

    public function testProcess() 
    {
        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        // проверяем, что в $mock находится экземпляр класса Client
        $client->assertInstanceOf(Client::class, $client);
    }

    public function testGetEmpty() 
    {    
        $data = $this->client->run('https://drom.ru');
        $this->assertEmpty($data);

        return $data;
    }
}

?>