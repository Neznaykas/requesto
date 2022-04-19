<?php

declare(strict_types=1);
include_once '../bootstrap.php';

use Drom\Client;

//Examples
const BASE_URL = 'https://dummyapi.io/data/v1/';
const APP_ID_VALUE = '617b11efbdaa719034cf6d83';

const POST_COMMENT_CREATE = 'comment/create';
const GET_USERS = 'user';
const PUT_USER = 'user/60d0fe4f5311236168a109ca';

echo Client::request('GET')
            ->setHeaders(array('app-id: ' . APP_ID_VALUE))
            ->setData(array('tst' => 'qwest'))
            ->run(BASE_URL . GET_USERS) . PHP_EOL; //PHP_EOL - только чтобы норм смотрелось в консоли

$params = array(
    'message' => 'qwest',
    'owner' => '60d0fe4f5311236168a109d0',
    'post' => '60d21b7967d0d8992e610d1b'
);

echo Client::request('POST')
            ->setHeaders(array('app-id: ' . APP_ID_VALUE))
            ->setData($params)
            ->run(BASE_URL . POST_COMMENT_CREATE) . PHP_EOL;

$response = Client::request('PUT')
            ->setHeaders(array('app-id: ' . APP_ID_VALUE))
            ->setData(
                array('firstName' => 'qwest')
            );

echo $response->run(BASE_URL . PUT_USER);
