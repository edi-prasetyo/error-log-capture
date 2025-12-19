<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Error Log Capture
    |--------------------------------------------------------------------------
    |
    | Master switch to enable or disable error logging.
    |
    */

    'enabled' => env('ERROR_LOG_CAPTURE_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Ignore Exceptions
    |--------------------------------------------------------------------------
    |
    | List of exception classes that should NOT be logged.
    |
    */

    'ignore' => [
        \Illuminate\Validation\ValidationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Stack Trace Limit
    |--------------------------------------------------------------------------
    |
    | Limit number of stack trace frames stored in database.
    |
    */

    'trace_limit' => env('ERROR_LOG_CAPTURE_TRACE_LIMIT', 10),
];
