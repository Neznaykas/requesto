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

    use Drom\ExampleApi;
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\HttpFactory;
    use GuzzleHttp\Psr7;
    use GuzzleHttp\RequestOptions;
    use Psr\Http\Client\ClientExceptionInterface;

    const BASE_URL = 'https://dummyapi.io/data/v1/';
    const APP_ID_VALUE = '617b11efbdaa719034cf6d83';
    const POST_COMMENT = 'comment/create';
    const GET_USERS = 'user';
    const PUT_USER = 'user/';

    $params = array(
        'message' => 'qwest',
        'owner' => '60d0fe4f5311236168a109d0',
        'post' => '60d21b7967d0d8992e610d1b'
    );

    $client = new ExampleApi(new HttpFactory(), Psr7\Utils::streamFor(''),
        new Client(['base_uri' => BASE_URL, RequestOptions::HEADERS => ['app-id' => APP_ID_VALUE]]));

    echo '<p>Get Comments Test</p>';

    try {
        var_dump($client->getComments(GET_USERS));
        echo '<p>Update Comment</p>';

        var_dump($client->updateComment('60d0fe4f5311236168a109ca', ['firstName' => 'qwest'], PUT_USER));
        echo '<p>Add Comment</p>';

        var_dump($client->addComment($params, POST_COMMENT));
    } catch (ClientExceptionInterface $e) {
        var_dump($e->getMessage());
    }

    ?>
</div>
</body>
</html>