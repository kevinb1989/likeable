<?php

declare(strict_types=1);

namespace Kevinb1989\Likeable\Tests;

use Kevinb1989\Likeable\LikeableServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    use WithWorkbench;

    protected function getPackageProviders($app): array
    {
        return [
            LikeableServiceProvider::class,
        ];
    }
}
