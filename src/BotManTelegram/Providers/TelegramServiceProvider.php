<?php

namespace Duke\Horizon\BotManTelegram\Providers;

use Illuminate\Support\ServiceProvider;
use Duke\Horizon\BotMan\Drivers\DriverManager;
use Duke\Horizon\BotMan\Drivers\Telegram\TelegramDriver;
use Duke\Horizon\BotMan\Drivers\Telegram\TelegramFileDriver;
use Duke\Horizon\BotMan\Drivers\Telegram\TelegramAudioDriver;
use Duke\Horizon\BotMan\Drivers\Telegram\TelegramPhotoDriver;
use Duke\Horizon\BotMan\Drivers\Telegram\TelegramVideoDriver;
use Duke\Horizon\BotMan\Studio\Providers\StudioServiceProvider;
use Duke\Horizon\BotMan\Drivers\Telegram\TelegramLocationDriver;
use Duke\Horizon\BotMan\Drivers\Telegram\TelegramContactDriver;
use Duke\Horizon\BotMan\Drivers\Telegram\Console\Commands\TelegramRegisterCommand;

class TelegramServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->isRunningInBotManStudio()) {
            $this->loadDrivers();

            $this->publishes([
                __DIR__.'/../../stubs/telegram.php' => config_path('botman/telegram.php'),
            ]);

            $this->mergeConfigFrom(__DIR__.'/../../stubs/telegram.php', 'botman.telegram');

            $this->commands([
                TelegramRegisterCommand::class,
            ]);
        }
    }

    /**
     * Load BotMan drivers.
     */
    protected function loadDrivers()
    {
        DriverManager::loadDriver(TelegramDriver::class);
        DriverManager::loadDriver(TelegramAudioDriver::class);
        DriverManager::loadDriver(TelegramFileDriver::class);
        DriverManager::loadDriver(TelegramLocationDriver::class);
        DriverManager::loadDriver(TelegramContactDriver::class);
        DriverManager::loadDriver(TelegramPhotoDriver::class);
        DriverManager::loadDriver(TelegramVideoDriver::class);
    }

    /**
     * @return bool
     */
    protected function isRunningInBotManStudio()
    {
        return class_exists(StudioServiceProvider::class);
    }
}
