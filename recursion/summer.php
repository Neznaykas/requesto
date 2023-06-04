<?php

function findAndSum(string $dir): float|int
{
    $files = scandir($dir) ?? [];
    $total = 0;

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            $total += findAndSum($path);
        } elseif (is_file($path) && str_contains($file, 'count')) {
            try {
                $handle = fopen($path, 'r');
                if (!$handle) {
                    throw new \Exception('Cannot open file');
                }

                while (!feof($handle)) {
                    $buffer = fread($handle, 4096);
                    $matches = [];
                    preg_match_all('/[-+]?\d+(\.\d+)?/', $buffer, $matches);
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
    echo ($dir && is_dir($dir)) ? findAndSum($dir) : 'please, set directory';
}