<?php

namespace Skyracer2012\HttpMailDriver;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;

class HttpMailDriverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Mail::extend('http', function (array $config = []) {
            return new HttpTransport(Arr::get($config, 'url'), Arr::get($config, 'key'), Arr::get($config, 'dkim_enabled'), Arr::get($config, 'dkim_domain'), Arr::get($config, 'dkim_selector'), Arr::get($config, 'dkim_private_key'));
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'http-mail-driver');

        // Register the main class to use with the facade
        $this->app->singleton('http-mail-driver', function () {
            return new HttpMailDriver;
        });
    }
}
