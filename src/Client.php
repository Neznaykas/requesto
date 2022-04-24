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
    
    public function get(string $url, array $data = []): string;
    public function post(string $url, $data = []): string;
    public function put(string $url, $data = []): string;
    public function getStatusCode(): int;
}

class Client implements ClientInterface
{
    private AbstractHttpMethod $method;
    private array $headers = []; 

    public function get(string $url, array $data = []): string
    {
        $this->method = AbstractHttpMethod::request('GET');

        return $this->method
            ->setHeaders($this->headers)
            ->setData($data)
            ->run($url);
    }

    public function post(string $url, $data = []): string
    {
        $this->method =  AbstractHttpMethod::request('POST');
        
        return $this->method
            ->setHeaders($this->headers)
            ->setData($data)
            ->run($url);
    }

    public function put(string $url, $headers = [], $data = []): string
    {
        $this->method = AbstractHttpMethod::request('PUT');
        
        return $this->method
            ->setHeaders($this->headers)
            ->setData($data)
            ->run($url);
    }

    public function withHeaders(array $headers)
    {
        //$this->method->setHeaders($headers);
        $this->headers = $headers;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->method->getStatusCode();
    }

}

?>