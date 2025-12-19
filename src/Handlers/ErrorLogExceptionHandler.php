<?php

namespace EdiPrasetyo\ErrorLogCapture\Handlers;

use Throwable;
use Illuminate\Contracts\Debug\ExceptionHandler;
use EdiPrasetyo\ErrorLogCapture\Services\ErrorLogCapture;
use EdiPrasetyo\ErrorLogCapture\Support\ErrorContext;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorLogExceptionHandler implements ExceptionHandler
{
    public function __construct(
        protected ExceptionHandler $handler,
        protected ErrorLogCapture $capture
    ) {}

    public function report(Throwable $e): void
    {
        if ($this->handler->shouldReport($e)) {
            try {
                $log = $this->capture->capture($e);
                ErrorContext::set($log);
            } catch (\Throwable $internal) {
                // fail-safe
            }
        }

        $this->handler->report($e);
    }

    public function shouldReport(Throwable $e): bool
    {
        return $this->handler->shouldReport($e);
    }

    public function render($request, Throwable $e)
    {
        if (
            $e instanceof HttpExceptionInterface &&
            app()->environment('production') &&
            !config('app.debug')
        ) {
            $log = ErrorContext::get();

            if ($log) {
                return response()->view(
                    'error-log-capture::error',
                    [
                        'id'   => $log->id,
                        'hash' => $log->hash,
                    ],
                    500
                );
            }
        }

        return $this->handler->render($request, $e);
    }

    public function renderForConsole($output, Throwable $e): void
    {
        $this->handler->renderForConsole($output, $e);
    }
}
