<?php

namespace Drom;

/*use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

interface RequestFactoryInterface
{
    /**
     * Create a new request.
     *
     * @param string $method The HTTP method associated with the request.
     * @param UriInterface|string $uri The URI associated with the request. 
     */
    //public function createRequest(string $method, $uri): RequestInterface;
//}

class Client //Facade
{
    public function __construct()
    {
        //$this->client = new AbstractHttpMethod();
    }

    public static function get()
    {
        return AbstractHttpMethod::request('GET');;
    }

    public static function post()
    {
        return AbstractHttpMethod::request('POST');
    }

    public static function put()
    {
        return AbstractHttpMethod::request('PUT');
    }
}

?>