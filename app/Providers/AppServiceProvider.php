<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Models\Booking;
use App\Policies\BookingPolicy;
use App\Services\BookingService;
use App\Services\MidtransService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Services
        $this->app->singleton(BookingService::class, function ($app) {
            return new BookingService();
        });

        $this->app->singleton(MidtransService::class, function ($app) {
            return new MidtransService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Gate $gate): void
    {
        // Register Policies
        $gate->policy(Booking::class, BookingPolicy::class);
    }
}
