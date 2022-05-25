<?php

function find_and_sum($dir, $delim)
{
    $root = scandir($dir);
    $sum = 0; //не обязательно, но оставлю

    foreach ($root as $value) {
        if ($value === '.' || $value === '..') {
            continue;
        }

        $path = $dir . $delim . $value;

        if (is_file($path)) {
            $string = file_get_contents($path);

            print_r($string);
            echo '</br>';

            //отрицательные, положительные, дробные, с любым разделителем
            preg_match_all("!(?:\-+)?\d+(?:\.\d+)?!", $string, $out, PREG_PATTERN_ORDER);

            $sum += array_sum($out[0]);
            continue;
        }
        $sum += find_and_sum($path, $delim);
    }
    return $sum;
}

//на случай запуска на mac\linux
$delimetr = (PHP_OS == 'WINNT') ? '\\' : '/';
//предпологаю, что в корне
$current = $delimetr .'dirs';
//вызов и вывод поиска
print_r('Сумма найденных значений: ' . find_and_sum(__DIR__  . $current, $delimetr));
