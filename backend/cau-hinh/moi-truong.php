
<?php

$duongDanEnv = dirname(__DIR__, 2) . '/.env';

if (!file_exists($duongDanEnv)) {
    die('Khong tim thay file .env');
}

$dongEnv = file($duongDanEnv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($dongEnv as $dong) {
    $dong = trim($dong);

    if ($dong === '' || str_starts_with($dong, '#')) {
        continue;
    }

    [$khoa, $giaTri] = array_pad(explode('=', $dong, 2), 2, '');

    $_ENV[trim($khoa)] = trim($giaTri);
}
