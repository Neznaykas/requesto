## Requesto - Coding Challenge

## Быстрый старт

<p>1. Run <code> docker compose -f deploy/docker-compose.yml up -d;</code></p>
<p></p>
<p>2. Open <a href="http://localhost ">localhost</a> in browser</p>

<p>3. Run Dev Tests</p>
<p><code>docker run --rm -t app php ./client/vendor/bin/phpunit</code></p>
<p><code> docker compose exec php ./client/vendor/bin/phpunit client/tests</code></p>

## Структура проекта

<p><code>1. client - реализация http клиента</code></p>

Необходимо реализовать клиент для абстрактного (вымышленного) сервиса комментариев "example.com". Проект должен представлять класс или набор классов, который будет делать http запросы к серверу.
На выходе должна получиться библиотека, которую можно будет подключить через composer к любому другому проекту.
У этого сервиса есть 3 метода:

GET http://example.com/comments - возвращает список комментариев
<br>POST http://example.com/comment - добавить комментарий.
<br>PUT http://example.com/comment/{id} - по идентификатору комментария обновляет поля, которые были в в запросе
Объект comment содержит поля:
id - тип int. Не нужно указывать при добавлении.
name - тип string.
text - тип string.

Написать phpunit тесты, на которых будет проверяться работоспособность клиента.
Сервер example.com писать не надо! Только библиотеку для работы с ним.

## Пример

```php

class ExampleService
{
    public function __construct(
        private readonly Drom\ExampleApi $client
    ) {
    }
    
    public function method(): ...
    {
        try {
            /** @var Comment[] */
            $comments = $this->client->getComments();
        } catch (\ClientExceptionInterface $e) {
            ...
        }
    } 
}

$service = new ExampleService(new ExampleApi(new HttpFactory(), Psr7\Utils::streamFor(''), new Client());
```

<p><code>2. Директория recursion - реализация обхода директорий</code></p>

Есть список директорий неизвестно насколько большой вложенности
В директории может быть файл count
Нужно пройтись по всем директориям и вернуть сумму всех чисел из файла count (файлов count может быть много)

```php
echo 'Сумма значений: ' . findAndSum('/recursion/dirs');
```
<p><code>3. deploy - конфигурация сборки для docker или k8s</code></p>

index.php - точка входа
