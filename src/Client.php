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

    public static function get(string $url, array $headers = [], array $data = []): string;
    public static function post(string $url, $headers = [], $data = []): string;
    public static function put(string $url, $headers = [], $data = []): string;
}

class Client implements ClientInterface
{
    public static function get(string $url, array $headers = [], array $data = []): string
    {
        return AbstractHttpMethod::request('GET')
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public static function post(string $url, $headers = [], $data = []): string
    {
        return AbstractHttpMethod::request('POST')
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public static function put(string $url, $headers = [], $data = []): string
    {
        return AbstractHttpMethod::request('PUT')
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }
}

?>