<?php

include_once '../vendor/autoload.php';
use Drom\ExampleApi;

//Examples
const BASE_URL = 'https://dummyapi.io/data/v1/';
const APP_ID_VALUE = '617b11efbdaa719034cf6d83';

const POST_COMMENT = BASE_URL . 'comment/create';
const GET_USERS = BASE_URL . 'user';
const PUT_USER = BASE_URL . 'user/60d0fe4f5311236168a109ca';

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