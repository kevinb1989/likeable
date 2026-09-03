<?php

declare(strict_types=1);

use Likeable\Likeable\Likeable;

it('resolves the singleton', function () {
    expect(app(Likeable::class))->toBeInstanceOf(Likeable::class);
});

it('returns the same instance from the container', function () {
    expect(app(Likeable::class))->toBe(app(Likeable::class));
});
