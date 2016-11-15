<?php

namespace App\Providers;

use App\Composers\AlertMessageComposer;
use App\Composers\UserNotificationComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('*',AlertMessageComposer::class);
        view()->composer('*',UserNotificationComposer::class);
    }
}
