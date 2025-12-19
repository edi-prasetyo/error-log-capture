<?php

namespace EdiPrasetyo\ErrorLogCapture\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use EdiPrasetyo\ErrorLogCapture\ErrorLogCaptureServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ErrorLogCaptureServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
