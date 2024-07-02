<?php

use Kirby\Toolkit\Str;

Kirby::plugin('sakila/actors', [
    'pageMethods' => [
        'filmsByActor' => function () {
            // SLOW
            // $films = page('film')->children()->filter(fn ($film) => $film->actors()->toPages()->has($this));

            // FAST
            // $films = page('film')->children()->filter(fn ($film) => Str::contains($film->actors()->value(), $this->uuid()->toString()));

            // with mongodb
            $films = khulan([
                'actors[]' => ['$in' => $this->uuid()->toString()],
            ]);

            ray($films);

            return implode('<br>', $films->map(fn ($film) => $film->title())->values());
        },
    ],
    'routes' => [
        [
            'pattern' => 'actor/(:any)/films',
            'action' => function ($slug) {
                if ($actor = page('actor/'.$slug)) {
                    return $actor->filmsByActor();
                }

                return '';
            },
        ],
    ],
]);
