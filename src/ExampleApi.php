<?php

namespace Drom;

use Drom\Http\HttpMethod;

class Comment
{
    private $id;
    private $name;
}

class Coomments extends Comment
{
    public array $commends;
}

class ExampleApi //implements ClientInterface
{
    private HttpMethod $method;

    public function __construct()
    {
        $this->method = new HttpMethod;

        if (Config::APP_ID_VALUE !== null)
            $this->method->setHeaders(['app-id: ' . Config::APP_ID_VALUE]);
    }

    public function getComments(): string//Coomments 
    {
        return $this->method->get(Config::GET_USERS);
    }

    public function addComment($data): string
    {
        return $this->method->setData($data)->post(Config::POST_COMMENT);
    }

    public function updateComment($data): string
    {
        return $this->method
               ->setData($data)
               ->put(Config::PUT_USER);
    }
}
