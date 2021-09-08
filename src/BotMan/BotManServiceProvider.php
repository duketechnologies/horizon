<?php

namespace Duke\Horizon\BotMan;

use Duke\Horizon\BotMan\Cache\LaravelCache;
use Duke\Horizon\BotMan\Container\LaravelContainer;
use Duke\Horizon\BotMan\Storages\Drivers\FileStorage;
use Illuminate\Support\ServiceProvider;

class BotManServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('botman', function ($app) {
            $storage = new FileStorage(storage_path('botman'));

            $botman = BotManFactory::create(config('botman', []), new LaravelCache(), $app->make('request'),
                $storage);

            $botman->setContainer(new LaravelContainer($this->app));

            return $botman;
        });
    }
}
