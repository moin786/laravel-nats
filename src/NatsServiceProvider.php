<?php

namespace PealIhertz\LaravelNats;

use Illuminate\Support\ServiceProvider;

class NatsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/nats.php' => config_path('nats.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\NatsConsume::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nats.php', 'nats');

        $this->app->singleton('laravel-nats', function ($app) {
            $config = $app['config']->get('nats', []);
            return new NatsManager($config);
        });
    }
}