<?php

namespace App\Providers;

use App\Contracts\ResponseStrategy;
use App\Models\Order;
use App\Policies\OrderPolicy;
use App\Services\Responses\JsonResponseStrategy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Order::class => OrderPolicy::class,
    ];

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
        // Registering policies
        Gate::policy(Order::class, OrderPolicy::class);
    }
}
