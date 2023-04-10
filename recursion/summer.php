<?php

function findAndSum(string $dir): float|int
{
    $directory = new DirectoryIterator($dir);
    $sum = 0;

    foreach ($directory as $fileInfo) {
        // Отбрасываем ".", ".." и скрытые файлы.
        if ($fileInfo->isDot() || $fileInfo->isFile() && str_starts_with($fileInfo->getFilename(), '.')) {
            continue;
        }

        if ($fileInfo->isDir()) {
            // Рекурсивно вызываем функцию для директории.
            $subdirSum = findAndSum($fileInfo->getPathname());
            $sum += $subdirSum;
        } elseif ($fileInfo->isFile() && str_contains($fileInfo->getFilename(), 'count')) {
            // Считываем и суммируем числа из файла.
            $lines = file($fileInfo->getPathname(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $numbers = array_filter($lines, fn($line) => is_numeric($line));
            $sum += array_reduce($numbers, fn($carry, $number) => $carry + $number, 0);
        }
    }

    return $sum;
}

$dir = 'dirs';
echo 'Сумма найденных значений: ' . findAndSum(__DIR__ . '/' . $dir);