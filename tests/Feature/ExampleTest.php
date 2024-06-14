<?php

test('example', function () {
    expect(true)->toBeTrue();
});

use function Pest\Stressless\stress;

it('has a fast response time', function () {
    $result = stress('http://sakila.test');
    $result->dd();

    // expect($result->requests()->duration()->med())->toBeLessThan(100); // < 100.00ms
});
