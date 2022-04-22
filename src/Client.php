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
    private static $method;

    public static function get(string $url, array $headers = [], array $data = []): string
    {
        self::$method = AbstractHttpMethod::request('GET');

        return self::$method
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public static function post(string $url, $headers = [], $data = []): string
    {
        self::$method =  AbstractHttpMethod::request('POST');
        
        return self::$method
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public static function put(string $url, $headers = [], $data = []): string
    {
        self::$method =  AbstractHttpMethod::request('put');
        
        return self::$method
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public static function getStatusCode(): int
    {
        return self::$method->getStatusCode();
    }
}

?>