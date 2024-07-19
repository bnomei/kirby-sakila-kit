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
    'bnomei.nitro.json-encode-flags' => JSON_INVALID_UTF8_SUBSTITUTE | JSON_THROW_ON_ERROR,
    'bnomei.nitro.max-dirty-cache' => 99999999,
    'bnomei.lapse.cache' => [
        'type' => 'nitro',
    ],
    'cache' => [
        'uuid' => [
            'type' => 'nitro',
        ],
    ],
];
