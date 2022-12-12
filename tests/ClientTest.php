<?php

namespace Tests;

use Drom\Config;
use Drom\Http\HttpMethod;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = new HttpMethod;
    }

    public function tearDown(): void {
        $this->client = null;
    }

    public function testGet()
    {
        $client = $this->getMockBuilder(HttpMethod::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client->method('get')->willReturn('{"error":"APP_ID_MISSING"}');

        $this->assertSame('{"error":"APP_ID_MISSING"}', $client->method->get(Config::BASE_URL));
    }

    public function testProcess() 
    {
        $client = $this->getMockBuilder(HttpMethod::class)
            ->disableOriginalConstructor()
            ->getMock();

        // проверяем, что в $mock находится экземпляр класса Client
        $this->assertInstanceOf(HttpMethod::class, $client);
    }
}

?>