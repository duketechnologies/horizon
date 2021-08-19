<?php

namespace Duke\Horizon;

use Illuminate\Support\ServiceProvider;

class HorizonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Commands\HorizonInstallCommand::class,
        ]);
    }

    public function provides()
    {
        return [Commands\HorizonInstallCommand::class];
    }
}
