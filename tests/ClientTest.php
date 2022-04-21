<?php

include_once 'bootstrap.php';

use PHPUnit\Framework\TestCase;

use Drom\Client;

const BASE_URL = 'https://dummyapi.io/data/v1/';
const COMMENTS_URL = 'comment/';
const APP_ID_VALUE = '617b11efbdaa719034cf6d83';

class ClientTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        $this->client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
    /**
     * @expectedException InvalidArgumentException
     */
    public function testProcess() 
    {
        $mock = $this->createMock('Client');
        // проверяем, что в $mock находится экземпляр класса Client
        $this->assertInstanceOf(Client::class, $mock);
    }

    public function testGetEmpty() 
    {    
        $data = $this->client->run('https://drom.ru');
        $this->assertEmpty($data);

        return $data;
    }

    public function testGet() 
    {
        $client = $this->createMock('Client');
        
        $client->expects($this->any())
              ->method('get')
              ->will($this->returnValue('not JSON'));

        $response = Client::get('https://drom.ru');

        $this->assertEmpty($client->get('https://drom.ru'));
    }
    
    //$this->expectException('HttpResponseException');
}

?>