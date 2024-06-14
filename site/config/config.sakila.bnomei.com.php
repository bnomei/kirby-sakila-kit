<?php

return [
    'debug' => false,
    'updates' => [
        'kirby' => false,
    ],
    'bnomei.lapse.cache' => [
        'type' => 'file',
    ],
    'bnomei.boost.cache' => [
        'type' => 'apcu',
    ],
    'cache' => [
        'uuid' => [
            'type' => 'apcu',
        ],
    ],
];
