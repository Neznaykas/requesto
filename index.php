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

    $dirsPath = __DIR__ . '/recursion/dirs';

    $start = microtime(true);
    $sum = mainFindAndSum($dirsPath);
    $time = microtime(true) - $start;

    echo "Сумма найденных значений: $sum<br>";
    echo "Время выполнения: $time секунд.<br><br>";

    $start = microtime(true);
    $sum = oldStyleFindAndSum($dirsPath);
    $time = microtime(true) - $start;

    echo "Сумма найденных значений: $sum<br>";
    echo "Время выполнения: $time секунд.";
    ?>

    <h4>Dummyapi Example</h4>

    <?php
    require_once __DIR__ . '/client/vendor/autoload.php';

    use Drom\ExampleApi;
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\HttpFactory;
    use GuzzleHttp\RequestOptions;
    use Laminas\Diactoros\StreamFactory;
    use Psr\Http\Client\ClientExceptionInterface;

    $client = new ExampleApi(new HttpFactory(), new StreamFactory(), new Client(['base_uri' => 'https://dummyapi.io/data/v1/', RequestOptions::HEADERS => ['app-id' => '617b11efbdaa719034cf6d83']]));

    try {
        echo '<p>Get Comments Test</p>';
        echo json_encode($client->getComments('comment'));

        echo '<p>Update Comment</p>';
        echo json_encode($client->updateComment('60d0fe4f5311236168a109ca', ['firstName' => 'qwest'], 'user/'));

        echo '<p>Add Comment</p>';
        $params = array('message' => 'qwest', 'owner' => '60d0fe4f5311236168a109d0', 'post' => '60d21b7967d0d8992e610d1b');

        echo json_encode($client->addComment($params, 'comment/create'));

    } catch (ClientExceptionInterface $e) {
        var_dump($e->getMessage());
    }

    ?>
</div>
</body>
</html>