<?php

namespace App\Providers;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // ignoring passport migration so we can change it and use uuid
        Passport::ignoreMigrations();

        $this->app->bind('App\Interfaces\UserInterfaceRepository','App\Repositories\UserRepository');

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Change passport client id to uuid
        Client::creating(function (Client $client) {
            $client->incrementing = false;
            $client->id = (string) Str::uuid();
        });

        // prevent passport from converting to integer
        Client::retrieved(function (Client $client) {
            $client->incrementing = false;
        });
    }
}
