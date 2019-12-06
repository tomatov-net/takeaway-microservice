<?php

namespace App\Providers;

use App\Repositories\RestaurantRepository;
use App\Services\Transport\GuzzleTransport;
use App\Services\Transport\TransportInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TransportInterface::class,
            GuzzleTransport::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('restaurantExists', function ($attribute, $value, $parameters) {
            $repository = new RestaurantRepository();
            return (bool) $repository->find($value);
        });
    }
}
