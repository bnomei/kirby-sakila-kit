<?php

return [
    'debug' => false,
    'editor' => 'phpstorm',
    'db' => [
        'host' => '127.0.0.1',
        'database' => 'sakila',
        'user' => 'root',
        'password' => '',
    ],
    'content' => [
        'locking' => false,
    ],
    'bnomei.php-cachedriver.check_opcache' => false,
    'bnomei.boost.cache' => [
        'type' => 'php',
    ],
    'bnomei.lapse.cache' => [
        'type' => 'php',
    ],
    'cache' => [
        'uuid' => [
            'type' => 'php',
        ],
    ],
];
