<?php

/*
@author Gabriel Ruelas
@licence MIT
@version 1.2.0

*/

namespace Equidna\Toolkit\Providers;

use Illuminate\Support\ServiceProvider;

class EquidnaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
    }

    public function boot(): void
    {
        $this->publishConfig();
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/equidna.php', 'equidna');
    }

    protected function publishConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/equidna.php' => config_path('equidna.php'),
        ], 'equidna:config');
    }
}
