## Requesto - Coding Challenge

<p>1. # Run</p> <code>docker compose up -d;</code> 
<code>docker-compose exec php composer install</code>
<p>2. Open <a href="http://localhost ">localhost</a> in browser</p>

<p>3. # Run Dev Tests</p>
<p><code> docker compose exec php composer test</code></p>

## Структура проекта

<p><code>1. Client - реализация http клиента</code></p>

Необходимо реализовать клиент для абстрактного (вымышленного) сервиса комментариев "example.com". Проект должен представлять класс или набор классов, который будет делать http запросы к серверу.
На выходе должна получиться библиотека, который можно будет подключить через composer к любому другому проекту.
У этого сервиса есть 3 метода:

GET http://example.com/comments - возвращает список комментариев
POST http://example.com/comment - добавить комментарий.
PUT http://example.com/comment/{id} - по идентификатору комментария обновляет поля, которые были в в запросе

Объект comment содержит поля:
id - тип int. Не нужно указывать при добавлении.
name - тип string.
text - тип string.

Написать phpunit тесты, на которых будет проверяться работоспособность клиента.
Сервер example.com писать не надо! Только библиотеку для работы с ним.


<p><code>2. Директория Recursion - реализация обхода директорий</code></p>

Есть список директорий неизвестно насколько большой вложенности
В директории может быть файл count
Нужно пройтись по всем директориям и вернуть сумму всех чисел из файла count (файлов count может быть много)

<p><code>Nginx - конфиг по умолчанию для веб-сервера</code></p>
