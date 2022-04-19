<?php

use PHPUnit\Framework\TestCase;

include_once 'client/Controller.php';
include_once 'client/Request.php';

const BASE_URL = 'https://dummyapi.io/data/v1/';
const COMMENTS_URL = 'comment/';
const APP_ID_VALUE = '617b11efbdaa719034cf6d83';

class ClientTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        $this->get = $this->getMockBuilder(GET::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = Client::request($this->get);
    }

    public function testGetEmpty() 
    {    
        $data = $this->client->run('https://drom.ru');
        $this->assertEmpty($data);

        return $data;
    }

    public function testGet() 
    {
        $http = $this->createMock('GET');
        $http->expects($this->any())
              ->method('run')
              ->will($this->returnValue('not JSON'));
        
            $response = Client::request($http);
            $this->assertEmpty($response->run('https://drom.ru'));
    }
    
    //$this->expectException('HttpResponseException');
}

?>