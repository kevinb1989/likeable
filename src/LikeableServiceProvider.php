<?php

declare(strict_types=1);

namespace Likeable\Likeable;

use Illuminate\Support\ServiceProvider;

class LikeableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], ['likeable', 'likeable-migrations']);
    }
}
