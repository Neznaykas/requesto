<?php

function findAndSum(string $dir): float|int
{
    $sum = 0;
    $directory = new RecursiveDirectoryIterator($dir);

    foreach (new RecursiveIteratorIterator($directory) as $fileInfo) {
        if ($fileInfo->isFile() && str_contains($fileInfo->getFilename(), 'count')) {
            $lines = file($fileInfo->getPathname(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $numbers = array_filter($lines, fn($line) => is_numeric($line));
            $sum += array_sum($numbers);
        }
    }

    return $sum;
}

if (PHP_SAPI == "cli") {
    $options = getopt("d");

    if (isset($options['d']))
        echo findAndSum($options['d']);
    else
        echo 'set param d - directory';
}