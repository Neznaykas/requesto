<?php

include_once '../bootstrap.php';

use Drom\Client;

//Examples
const BASE_URL = 'https://dummyapi.io/data/v1/';
const APP_ID_VALUE = '617b11efbdaa719034cf6d83';

const POST_COMMENT_CREATE = BASE_URL . 'comment/create';
const GET_USERS = BASE_URL . 'user';
const PUT_USER = BASE_URL . 'user/60d0fe4f5311236168a109ca';

echo Client::get(GET_USERS, ['app-id: ' . APP_ID_VALUE], ['tst' => 'qwest']);

echo PHP_EOL;

$params = array(
    'message' => 'qwest',
    'owner' => '60d0fe4f5311236168a109d0',
    'post' => '60d21b7967d0d8992e610d1b'
);

echo Client::post(POST_COMMENT_CREATE, ['app-id: ' . APP_ID_VALUE], $params);

echo PHP_EOL;

echo Client::put(PUT_USER, ['app-id: ' . APP_ID_VALUE], ['firstName' => 'qwest']);