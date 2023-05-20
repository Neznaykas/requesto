<?php

namespace Drom;

use Drom\Http\HttpMethod;

class ExampleApi
{
    private HttpMethod $method;
    private Config $config;

    public function __construct(Config $config)
    {
        $this->method = new HttpMethod();
        $this->config = $config;

        if ($config::APP_ID_VALUE !== null) {
            $this->method->setHeaders(['app-id: ' . $config::APP_ID_VALUE]);
        }
    }

    public function getComments(): string //Coomments
    {
        $response = $this->method->get($this->config::GET_USERS);

        return json_decode($response->getBody(), true);
    }

    public function addComment($data): string
    {
        return $this->method->setData($data)->post($this->config::POST_COMMENT);
    }

    public function updateComment($data): string
    {
        return $this->method
            ->setData($data)
            ->put($this->config::PUT_USER);
    }

}

class ExampleClient
{
    private $base_uri = 'http://example.com';
    private $client;

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => $this->base_uri]);
    }

    public function get($url)
    {
        return $this->client->get($url);
    }

    public function post($url, $data)
    {
        return $this->client->post($url, ['json' => $data]);
    }

    public function put($url, $data)
    {
        return $this->client->put($url, ['json' => $data]);
    }

    public function getComments()
    {
        $response = $this->get('/comments');
        return json_decode($response->getBody(), true);
    }

    public function addComment($comment)
    {
        $response = $this->post('/comment', $comment);
        return json_decode($response->getBody(), true);
    }

    public function updateComment($id, $comment)
    {
        $response = $this->put('/comment/'.$id, $comment);
        return json_decode($response->getBody(), true);
    }

    public function addCommentWithConfirmation($comment)
    {
        $response = $this->post('/comment', $comment);
        $statusCode = $response->getStatusCode();
        if ($statusCode === 201) {
            return json_decode($response->getBody(), true);
        } else {
            return false;
        }
    }

}
