<?php

namespace App\Providers;

use App\Contracts\ResponseStrategy;
use App\Services\Responses\JsonResponseStrategy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ResponseStrategy::class, JsonResponseStrategy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
