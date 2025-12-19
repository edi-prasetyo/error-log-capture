<?php

namespace EdiPrasetyo\ErrorLogCapture\Support;

use EdiPrasetyo\ErrorLogCapture\Models\ErrorLogModel;

class ErrorContext
{
    protected static ?ErrorLogModel $lastError = null;

    public static function set(?ErrorLogModel $log): void
    {
        self::$lastError = $log;
    }

    public static function get(): ?ErrorLogModel
    {
        return self::$lastError;
    }
}
