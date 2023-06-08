<!DOCTYPE html>
<html lang="RU">
<head>
    <title>Requesto</title>
</head>
<body>
<div class="container">
    <h4>Summer Result</h4>
    <?php
    require_once __DIR__ . '/recursion/summer.php';
    echo 'Сумма найденных значений: ' . findAndSum(__DIR__ . '/recursion/dirs');
    ?>

    <h4>Dummyapi Example</h4>

    <?php

    require_once __DIR__ . '/client/vendor/autoload.php';

    use Drom\ExampleApi;
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\HttpFactory;
    use GuzzleHttp\RequestOptions;
    use Psr\Http\Client\ClientExceptionInterface;
    use Laminas\Diactoros\StreamFactory;

    $client = new ExampleApi(new HttpFactory(), new StreamFactory(),
        new Client(['base_uri' => 'https://dummyapi.io/data/v1/', RequestOptions::HEADERS => ['app-id' => '617b11efbdaa719034cf6d83']]));

    try {
        echo '<p>Get Comments Test</p>';
        echo json_encode($client->getComments('user'));

        echo '<p>Update Comment</p>';
        echo json_encode($client->updateComment('60d0fe4f5311236168a109ca', ['firstName' => 'qwest'], 'user/'));

        echo '<p>Add Comment</p>';
        $params = array(
            'message' => 'qwest',
            'owner' => '60d0fe4f5311236168a109d0',
            'post' => '60d21b7967d0d8992e610d1b'
        );

        echo json_encode($client->addComment($params, 'comment/create'));

    } catch (ClientExceptionInterface $e) {
        var_dump($e->getMessage());
    }

    ?>
</div>
</body>
</html>