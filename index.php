<!DOCTYPE html>
<html lang="EN">
<head>
    <title>JSON Data</title>
</head>
<body>
<div class="container">
    <?php require_once __DIR__ . '/recursion/summer.php'; ?>

    <h4>Client Example</h4>

    <?php

    require_once __DIR__ . '/client/vendor/autoload.php';

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