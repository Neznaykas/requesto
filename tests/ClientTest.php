<?php

use PHPUnit\Framework\TestCase;
use Drom\Client;


class ClientTest extends TestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = new Client;
    }

    public function tearDown(): void {
        $this->client = null;
    }

    public function testGet()
    {
        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client->method('get')
            ->willReturn('{"error":"APP_ID_MISSING"}');

        $this->assertSame('{"error":"APP_ID_MISSING"}', $client->get(BASE_URL));
    }

    public function testProcess() 
    {
        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        // проверяем, что в $mock находится экземпляр класса Client
        $this->assertInstanceOf(Client::class, $client);
    }
}

?>