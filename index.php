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

    use Drom\CommentsClient;
    use Drom\Model\Comment;
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\HttpFactory;
    use GuzzleHttp\RequestOptions;
    use Laminas\Diactoros\StreamFactory;
    use Psr\Http\Client\ClientExceptionInterface;

    $client = new CommentsClient(new HttpFactory(), new StreamFactory(), new Client(['base_uri' => 'https://dummyapi.io/data/v1/', RequestOptions::HEADERS => ['app-id' => '617b11efbdaa719034cf6d83']]));

    try {
        echo '<p>Get Comments Test</p>';
        echo json_encode($client->getComments('comment'));

        echo '<p>Add Comment</p>';
        $comment = new Comment(null, 'test', 'test');
        $comment = $client->addComment($comment, 'comment/create');
        echo json_encode($comment);

        echo '<p>Update Comment</p>';
        $comment->setName('tester');
        echo json_encode($client->updateComment($comment, 'user/'));

    } catch (ClientExceptionInterface $e) {
        var_dump($e->getMessage());
    }

    ?>
</div>
</body>
</html>