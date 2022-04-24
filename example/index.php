<?php

include_once '../vendor/autoload.php';
use Drom\Client;
use Drom\ClientS;

//Examples
const BASE_URL = 'https://dummyapi.io/data/v1/';
const APP_ID_VALUE = '617b11efbdaa719034cf6d83';

const POST_COMMENT = BASE_URL . 'comment/create';
const GET_USERS = BASE_URL . 'user';
const PUT_USER = BASE_URL . 'user/60d0fe4f5311236168a109ca';

$client = new Client();
$client->withHeaders(['app-id: ' . APP_ID_VALUE]);

//GET
echo $client->get(GET_USERS, [], ['tst' => 'qwest']);
echo PHP_EOL;
echo 'Status:' . $client->getStatusCode() . PHP_EOL;

//POST
$params = array(
    'message' => 'qwest',
    'owner' => '60d0fe4f5311236168a109d0',
    'post' => '60d21b7967d0d8992e610d1b'
);

echo $client->post(POST_COMMENT, $params);
echo PHP_EOL;
echo 'Status:' . $client->getStatusCode() . PHP_EOL;
echo PHP_EOL;

//PUT
echo $client->put(PUT_USER, ['firstName' => 'qwest']);
echo 'Status:' . $client->getStatusCode() . PHP_EOL;


//Other
echo PHP_EOL;
echo 'Laravel style' . PHP_EOL;

//Get
echo ClientS::get(GET_USERS, ['app-id: ' . APP_ID_VALUE], ['tst' => 'qwest']);
//Post
echo ClientS::post(POST_COMMENT, ['app-id: ' . APP_ID_VALUE], $params);
//Put
echo ClientS::put(PUT_USER, ['app-id: ' . APP_ID_VALUE], ['firstName' => 'qwest']);