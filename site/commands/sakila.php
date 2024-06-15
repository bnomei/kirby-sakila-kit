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
                    'title' => $actor->first_name().' '.$actor->last_name(),
                ],
                Str::slug($actor->first_name().' '.$actor->last_name()),
                'actor',
                $cli
            );
        }

        $categories = Db::select('category');
        foreach ($categories as $category) {
            SakilaImport::updateOrCreate(
                page('category'),
                [
                    'category_id' => $category->category_id(),
                    'name' => $category->name(),
                    'title' => $category->name(),
                ],
                Str::slug($category->name()),
                'category',
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
                        fn ($actor) => page('actor')
                            ->children()
                            ->filterBy('actor_id', strval($actor->actor_id()))
                            ->first()?->uuid()->toString()
                    )->filterBy(fn ($actor) => ! empty($actor))->values(),
                    'categories' => Db::select('film_category', 'category_id', "film_id = $film->film_id")->map(
                        fn ($category) => page('category')
                            ->children()
                            ->filterBy('category_id', strval($category->category_id()))
                            ->first()?->uuid()->toString()
                    )->filterBy(fn ($category) => ! empty($category))->values(),
                ],
                Str::slug($film->title()),
                'film',
                $cli
            );
        }

        $countries = Db::select('country');
        foreach ($countries as $country) {
            SakilaImport::updateOrCreate(
                page('country'),
                [
                    'country_id' => $country->country_id(),
                    'country' => $country->country(),
                    'title' => $country->country(),
                ],
                Str::slug('country-'.$country->country_id()),
                'country',
                $cli
            );
        }

        $cities = Db::select('city');
        foreach ($cities as $city) {
            SakilaImport::updateOrCreate(
                page('city'),
                [
                    'city_id' => $city->city_id(),
                    'city' => $city->city(),
                    'title' => $city->city(),
                    'country' => page('country')
                        ->children()
                        ->filterBy('country_id', strval($city->country_id()))
                        ->first()?->uuid()->toString(),
                ],
                Str::slug('city-'.$city->city_id()),
                'city',
                $cli
            );
        }

        $addresses = Db::select('address');
        foreach ($addresses as $address) {
            SakilaImport::updateOrCreate(
                page('address'),
                [
                    'address_id' => $address->address_id(),
                    'title' => md5($address->address()),
                    'address' => $address->address(),
                    'address2' => $address->address2(),
                    'district' => $address->district(),
                    'city' => page('city')
                        ->children()
                        ->filterBy('city_id', strval($address->city_id()))
                        ->first()?->uuid()->toString(),
                    'postal_code' => $address->postal_code(),
                    'phone' => $address->phone(),
                    'location' => $address->location(),
                ],
                Str::slug('address-'.$address->address_id()),
                'address',
                $cli
            );
        }

        $stores = Db::select('store');
        foreach ($stores as $store) {
            SakilaImport::updateOrCreate(
                page('store'),
                [
                    'store_id' => $store->store_id(),
                    'title' => 'Store '.$store->store_id(),
                    //                    'manager_staff' => page('staff')
                    //                        ->children()
                    //                        ->filterBy('staff_id', strval($store->manager_staff_id()))
                    //                        ->first()?->uuid()->toString(),
                    'address' => page('address')
                        ->children()
                        ->filterBy('address_id', strval($store->address_id())
                        )->first()?->uuid()->toString(),
                ],
                Str::slug('store-'.$store->store_id()),
                'store',
                $cli
            );
        }

        $inventory = Db::select('inventory');
        foreach ($inventory as $item) {
            SakilaImport::updateOrCreate(
                page('inventory'),
                [
                    'inventory_id' => $item->inventory_id(),
                    'title' => 'Inv '.$item->inventory_id(),
                    'film' => page('film')
                        ->children()
                        ->filterBy('film_id', strval($item->film_id()))
                        ->first()?->uuid()->toString(),
                    'store' => page('store')
                        ->children()
                        ->filterBy('store_id', strval($item->store_id()))
                        ->first()?->uuid()->toString(),
                ],
                Str::slug('inv-'.$item->inventory_id()),
                'inventory',
                $cli
            );
        }

        $customers = Db::select('customer');
        foreach ($customers as $customer) {
            SakilaImport::updateOrCreate(
                page('customer'),
                [
                    'customer_id' => $customer->customer_id(),
                    'store' => page('store')
                        ->children()
                        ->filterBy('store_id', strval($customer->store_id()))
                        ->first()?->uuid()->toString(),
                    'first_name' => $customer->first_name(),
                    'last_name' => $customer->last_name(),
                    'title' => $customer->first_name().' '.$customer->last_name(),
                    'email' => $customer->email(),
                    'address' => page('address')
                        ->children()
                        ->filterBy('address_id', strval($customer->address_id()))
                        ->first()?->uuid()->toString(),
                    'active' => $customer->active(),
                ],
                Str::slug($customer->first_name().' '.$customer->last_name()),
                'customer',
                $cli
            );
        }

        $rentals = Db::select('rental');
        foreach ($rentals as $rental) {
            SakilaImport::updateOrCreate(
                page('rental'),
                [
                    'rental_id' => $rental->rental_id(),
                    'title' => 'Rental '.$rental->rental_id(),
                    'rental_date' => $rental->rental_date(),
                    'return_date' => $rental->return_date(),
                    'inventory' => page('inventory')
                        ->children()
                        ->filterBy('inventory_id', strval($rental->inventory_id()))
                        ->first()?->uuid()->toString(),
                    'customer' => page('customer')
                        ->children()
                        ->filterBy('customer_id', strval($rental->customer_id()))
                        ->first()?->uuid()->toString(),
                    //                    'staff' => page('staff')
                    //                        ->children()
                    //                        ->filterBy('staff_id', strval($rental->staff_id()))
                    //                        ->first()?->uuid()->toString(),
                ],
                Str::slug('Rental '.$rental->rental_id()),
                'rental',
                $cli
            );
        }

        $cli->success('Done.');
    },
];

class SakilaImport
{
    public static function updateOrCreate($parent, $content, $slug, $template, $cli): Page
    {
        $page = page($parent->id().'/'.$slug);
        if ($page) {
            $page->update($content);
            $cli->out('↪️ '.$page->id());
        } else {
            $page = $parent->createChild([
                'slug' => $slug,
                'content' => $content,
                'template' => $template,
            ]);
            $page = $page->changeStatus('unlisted');
            $cli->out('🆕 '.$page->id());
        }

        return $page;
    }
}
