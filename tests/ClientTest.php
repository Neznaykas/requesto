<?php

use PHPUnit\Framework\TestCase;
use Drom\Client;

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