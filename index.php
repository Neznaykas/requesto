<!DOCTYPE html>
<html lang="RU">
<head>
    <title>JSON Data</title>
</head>
<body>
<div class="container">
    <h4>Summer Result</h4>
    <?php
        require_once __DIR__ . '/recursion/summer.php';
        echo 'Сумма найденных значений: ' . findAndSum(__DIR__ . '/recursion/dirs');
    ?>

    <h4>Client Example</h4>

    <?php

    require_once __DIR__ . '/client/vendor/autoload.php';

    const BASE_URL = 'https://dummyapi.io/data/v1/';
    const APP_ID_VALUE = '617b11efbdaa719034cf6d83';
    const POST_COMMENT = BASE_URL . 'comment/create';
    const GET_USERS = BASE_URL . 'user';
    const PUT_USER = BASE_URL . 'user/60d0fe4f5311236168a109ca';

    use Drom\ExampleApi;

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

    ?>
</div>
</body>
</html>