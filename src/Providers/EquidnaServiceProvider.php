<?php

/*
@author Gabriel Ruelas
@licence MIT
@version 0.6.0

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
        // Load routes
        $this->publishConfig();

        // Register custom exception handlers
        $this->registerExceptionHandlers();
    }

    protected function registerExceptionHandlers(): void
    {
        $exceptions = [
            \Equidna\Toolkit\Exceptions\BadRequestException::class,
            \Equidna\Toolkit\Exceptions\UnauthorizedException::class,
            \Equidna\Toolkit\Exceptions\ForbiddenException::class,
            \Equidna\Toolkit\Exceptions\NotFoundException::class,
            \Equidna\Toolkit\Exceptions\NotAcceptableException::class,
            \Equidna\Toolkit\Exceptions\ConflictException::class,
            \Equidna\Toolkit\Exceptions\UnprocessableEntityException::class,
            \Equidna\Toolkit\Exceptions\TooManyRequestsException::class,
        ];

        foreach ($exceptions as $exception) {
            $this->app->bind($exception, function ($app) use ($exception) {
                return new $exception();
            });
        }
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
