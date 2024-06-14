<?php

use Kirby\Cms\Page;
use Kirby\Database\Db;
use Kirby\Toolkit\Str;

return [
    'description' => 'Import Sakila database',
    'args' => [],
    'command' => static function ($cli): void {

        $kirby = $cli->kirby();
        $kirby->impersonate('kirby');

        $actors = Db::select('actor');
        foreach ($actors as $actor) {
            SakilaImport::updateOrCreate(
                page('actor'),
                [
                    'actor_id' => $actor->actor_id(),
                    'first_name' => $actor->first_name(),
                    'last_name' => $actor->last_name(),
                    'title' => $actor->first_name() . ' ' . $actor->last_name(),
                ],
                Str::slug($actor->first_name() . ' ' . $actor->last_name()),
                'actor',
                $cli
            );
        }

        $films = Db::select('film');
        foreach ($films as $film) {
            SakilaImport::updateOrCreate(
                page('film'),
                [
                    'film_id' => $film->film_id(),
                    'title' => $film->title(),
                    'description' => $film->description(),
                    'release_year' => $film->release_year(),
                    'length' => $film->length(),
                    'rating' => $film->rating(),
                    'special_features' => $film->special_features(),
                    'actors' => Db::select('film_actor', 'actor_id', "film_id = $film->film_id")->map(
                        fn($actor) => page('actor')
                            ->children()
                            ->filterBy('actor_id', strval($actor->actor_id()))
                            ->first()?->uuid()->toString()
                    )->filterBy(fn($actor) => !empty($actor))->values(),
                ],
                Str::slug($film->title()),
                'film',
                $cli
            );
        }

        $cli->success('Nice command!');
    },
];

class SakilaImport
{
    public static function updateOrCreate($parent, $content, $slug, $template, $cli): Page
    {
        $page = page($parent->id() . '/' . $slug);
        if ($page) {
            $page->update($content);
            $cli->out('↪️ ' . $page->id());
        } else {
            $page = $parent->createChild([
                'slug' => $slug,
                'content' => $content,
                'template' => $template,
            ]);
            $page = $page->changeStatus('unlisted');
            $cli->out('🆕 ' . $page->id());
        }

        return $page;
    }
}
