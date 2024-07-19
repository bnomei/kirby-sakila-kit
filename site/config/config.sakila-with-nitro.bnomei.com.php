<?php

return [
    'debug' => false,
    'updates' => [
        'kirby' => false,
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
