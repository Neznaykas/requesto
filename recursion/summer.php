<?php

/* Медленнее, чем обычная рекурсия, но имеет свои плюсы */
function mainFindAndSum(string $dir): float|int
{
    $sum = 0;
    $directory = new RecursiveDirectoryIterator($dir);

    foreach (new RecursiveIteratorIterator($directory) as $fileInfo) {
        if ($fileInfo->isFile() && str_contains($fileInfo->getFilename(), 'count')) {

            $lines = file_get_contents($fileInfo->getPathname());
            preg_match_all('/[-+]?\d+(\.\d+)?/', $lines, $matches, PREG_SET_ORDER);

            $sum += array_sum(array_map(function ($match) {
                return floatval($match[0]);
            }, $matches));
        }
    }

    return $sum;
}

/* Больше кода, более сложен, но быстрее */
function oldStyleFindAndSum(string $dir): float|int
{
    $files = scandir($dir) ?? [];
    $total = 0;

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            $total += oldStyleFindAndSum($path);
        } elseif (is_file($path) && str_contains($file, 'count')) {
            try {
                $handle = fopen($path, 'r');

                while (($line = fgets($handle)) !== false) {
                    $matches = [];
                    preg_match_all('/[-+]?\d+(\.\d+)?/', $line, $matches);
                    $total += array_sum($matches[0]);
                }

                fclose($handle);
            } catch (\Exception) {
                continue;
            }
        }
    }

    return $total;
}

if (php_sapi_name() === 'cli') {
    $dir = $argv[1] ?? null;
    echo ($dir && is_dir($dir)) ? mainFindAndSum($dir) : 'please, set directory';
}