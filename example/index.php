<?php

include_once '../vendor/autoload.php';
use Drom\ExampleApi;

$client = new ExampleApi();

echo $client->getComments();

$params = array(
    'message' => 'qwest',
    'owner' => '60d0fe4f5311236168a109d0',
    'post' => '60d21b7967d0d8992e610d1b'
);

echo PHP_EOL;
echo PHP_EOL;

echo $client->addComment($params);

echo PHP_EOL;
echo PHP_EOL;

echo $client->updateComment(['firstName' => 'qwest']);