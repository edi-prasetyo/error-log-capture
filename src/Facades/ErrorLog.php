<?php

namespace EdiPrasetyo\ErrorLogCapture\Facades;

use Illuminate\Support\Facades\Facade;
use EdiPrasetyo\ErrorLogCapture\Services\ErrorLogCapture;

class ErrorLog extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ErrorLogCapture::class;
    }
}
