<?php

require_once __DIR__ . '/vendor/autoload.php';

use Drom\ExampleApi;

echo '<h4>Client Example</h4>';

$client = new ExampleApi();

echo '<p>Get Comments</p>';

echo $client->getComments();

echo '<p>Add Comment</p>';

$params = array(
    'message' => 'qwest',
    'owner' => '60d0fe4f5311236168a109d0',
    'post' => '60d21b7967d0d8992e610d1b'
);

echo $client->addComment($params);

echo '<p>Update Comment</p>';

echo $client->updateComment(['firstName' => 'qwest']);