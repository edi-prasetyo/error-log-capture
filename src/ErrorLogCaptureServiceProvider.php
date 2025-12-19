<?php

namespace EdiPrasetyo\ErrorLogCapture;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Exceptions\Events\ExceptionReported;
use Illuminate\Contracts\Debug\ExceptionHandler;
use EdiPrasetyo\ErrorLogCapture\Handlers\ErrorLogExceptionHandler;
use EdiPrasetyo\ErrorLogCapture\Services\ErrorLogCapture;
use EdiPrasetyo\ErrorLogCapture\Support\ErrorContext;

class ErrorLogCaptureServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/error-log-capture.php',
            'error-log-capture'
        );

        $this->app->singleton(ErrorLogCapture::class, function () {
            return new ErrorLogCapture();
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                \EdiPrasetyo\ErrorLogCapture\Console\CleanErrorLogs::class,
            ]);
        }

        $this->app->extend(ExceptionHandler::class, function ($handler, $app) {
            return new ErrorLogExceptionHandler(
                $handler,
                $app->make(ErrorLogCapture::class)
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/error-log-capture.php' => config_path('error-log-capture.php'),
        ], 'error-log-capture-config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->publishes([
            __DIR__ . '/../resources/views/errors' => resource_path('views/errors'),
        ], 'error-log-capture-views');
    }
}
