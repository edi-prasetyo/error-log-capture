<?php

namespace EdiPrasetyo\ErrorLogCapture\Services;

use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use EdiPrasetyo\ErrorLogCapture\Models\ErrorLogModel;
use Illuminate\Support\Arr;

class ErrorLogCapture
{
    public function capture(Throwable $e): ?ErrorLogModel
    {
        foreach (config('error-log-capture.ignore', []) as $ignored) {
            if ($e instanceof $ignored) {
                return null;
            }
        }

        $traceArray = $e->getTrace();

        $file = $e->getFile();
        $line = $e->getLine();

        foreach ($traceArray as $frame) {
            if (isset($frame['file']) && str_contains($frame['file'], '/app/')) {
                $file = $frame['file'];
                $line = $frame['line'] ?? $line;
                break;
            }
        }

        $hash = $this->makeHash($e, $file, $line);

        $existing = ErrorLogModel::where('hash', $hash)->first();

        if ($existing) {
            $existing->increment('count');
            return $existing;
        }

        return ErrorLogModel::create([
            'exception'   => class_basename($e),
            'message'     => $e->getMessage(),
            'file'        => $file,
            'line'        => $line,
            'trace'       => collect($traceArray)
                ->take(config('error-log-capture.trace_limit', 10))
                ->map(fn($item) => Arr::only($item, ['file', 'line', 'function', 'class']))
                ->toJson(),
            'url'         => Request::fullUrl(),
            'method'      => Request::method(),
            'ip'          => Request::ip(),
            'user_id'     => Auth::id(),
            'hash'        => $hash,
            'count'       => 1,
            'solved'      => 0,
            'occurred_at' => now(),
        ]);
    }

    protected function makeHash(Throwable $e, string $file, int $line): string
    {
        return sha1(
            get_class($e) . '|' . $file . '|' . $line
        );
    }
}
