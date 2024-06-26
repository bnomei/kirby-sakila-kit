<?php

test('example', function () {
    expect(true)->toBeTrue();
});

use function Pest\Stressless\stress;

it('has a fast response time on the homepage', function () {
    $result = stress('http://sakila.test');
    $result->dump();
    expect($result->requests()->duration()->med())->toBeLessThan(50);
});

it('has 1000 films', function () {
    $result = stress('http://sakila.test/film');
    $result->dump();
    expect($result->requests()->duration()->med())->toBeLessThan(100);
});

it('has 1000 films with actors each', function () {
    $result = stress('http://sakila.test/film?actors=1');
    $result->dump();
    expect($result->requests()->duration()->med())->toBeLessThan(100);
});

it('has 1000 films filterable by feature', function () {
    $result = stress('http://sakila.test/film?feature=Trailers');
    $result->dump();
    expect($result->requests()->duration()->med())->toBeLessThan(100);
});

it('can query films by actor', function () {
    $result = stress('http://sakila.test/actor/adam-grant/films');
    $result->dump();
    expect($result->requests()->duration()->med())->toBeLessThan(100);
});

it('has rentals', function () {
    $result = stress('http://sakila.test/rental');
    $result->dump();
    expect($result->requests()->duration()->med())->toBeLessThan(100);
});
