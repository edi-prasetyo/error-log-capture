<?php

namespace EdiPrasetyo\ErrorLogCapture\Tests\Feature;

use Throwable;
use Illuminate\Support\Facades\Schema;
use EdiPrasetyo\ErrorLogCapture\Tests\TestCase;
use EdiPrasetyo\ErrorLogCapture\Models\ErrorLogModel;
use EdiPrasetyo\ErrorLogCapture\Services\ErrorLogCapture;

class CaptureErrorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Run package migrations
        $this->loadMigrationsFrom(
            __DIR__ . '/../../database/migrations'
        );
    }

    /** @test */
    public function it_stores_exception_to_database()
    {
        $exception = new \RuntimeException('Test error message');

        app(ErrorLogCapture::class)->capture($exception);

        $this->assertDatabaseCount('error_logs', 1);

        $log = ErrorLogModel::first();

        $this->assertEquals(
            \RuntimeException::class,
            $log->exception
        );

        $this->assertEquals(
            'Test error message',
            $log->message
        );

        $this->assertNotEmpty($log->trace);
    }

    /** @test */
    public function it_does_not_fail_when_capture_is_called_twice()
    {
        $exception = new \Exception('Duplicate test');

        $service = app(ErrorLogCapture::class);

        $service->capture($exception);
        $service->capture($exception);

        // Service boleh dipanggil dua kali
        // tapi global handler yang mencegah double log
        $this->assertDatabaseCount('error_logs', 2);
    }
}
