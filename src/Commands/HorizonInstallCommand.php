<?php

namespace Duke\Horizon\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class HorizonInstallCommand extends Command
{
    protected $signature = 'horizon:install';

    protected $description = 'Install resources';

    public function handle()
    {
        // Bot Conversation, Middlewares anf ApiService...
        File::copyDirectory(__DIR__ . '/../../stubs/app/Bot', base_path('App/Bot'));

        // Rewrite Exceptions Handler...
        File::copy(__DIR__ . '/../../stubs/app/Exceptions/Handler.php', base_path('App/Exceptions/Handler.php'));

        // Rewrite RouteServiceProvider...
        File::copy(__DIR__ . '/../../stubs/app/Providers/RouteServiceProvider.php', base_path('App/Providers/RouteServiceProvider.php'));

        // Config...
        File::copy(__DIR__ . '/../../stubs/config/botman.php', base_path('config/botman.php'));

        // Langs...
        File::copyDirectory(__DIR__.'/../../stubs/lang', base_path('resources/lang'));

        // Routes...
        File::copyDirectory(__DIR__.'/../../stubs/routes', base_path('routes'));
    }
}
