<?php

namespace Drom;

use Drom\Methods\AbstractHttpMethod;

//Just for Singleton/Freendzone/OtherLols

interface ClientInterfaceStatic
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
    public static function getStatusCode(): int;
}

class ClientS implements ClientInterfaceStatic
{
    private static AbstractHttpMethod $method; 

    public static function get(string $url, array $headers = [], array $data = []): string
    {
        static::$method = AbstractHttpMethod::request('GET');

        return static::$method
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public static function post(string $url, $headers = [], $data = []): string
    {
        static::$method =  AbstractHttpMethod::request('POST');
        
        return static::$method
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public static function put(string $url, $headers = [], $data = []): string
    {
        static::$method = AbstractHttpMethod::request('PUT');
        
        return static::$method
            ->setHeaders($headers)
            ->setData($data)
            ->run($url);
    }

    public static function getStatusCode(): int
    {
        return static::$method->getStatusCode();
    }

}

?>