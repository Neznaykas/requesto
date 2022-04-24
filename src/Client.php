<?php

namespace Drom;

use Drom\Methods\AbstractHttpMethod;

interface ClientInterface
{
    /**
     * Create a new client.
     * @param string $url - Url request
     * @param array $headers - Headers
     * @param array $data - Message body
     */
    
    public function get(string $url, array $headers = [], array $data = []): string;
    public function post(string $url, $headers = [], $data = []): string;
    public function put(string $url, $headers = [], $data = []): string;
    public function getStatusCode(): int;
}

class Client implements ClientInterface
{
    private AbstractHttpMethod $method; 

    public function get(string $url, array $headers = [], array $data = []): string
    {
        $this->method = AbstractHttpMethod::request('GET');

        return $this->method
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public function post(string $url, $headers = [], $data = []): string
    {
        $this->method =  AbstractHttpMethod::request('POST');
        
        return $this->method
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public function put(string $url, $headers = [], $data = []): string
    {
        $this->method = AbstractHttpMethod::request('PUT');
        
        return $this->method
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public function getStatusCode(): int
    {
        return $this->method->getStatusCode();
    }

}

?>