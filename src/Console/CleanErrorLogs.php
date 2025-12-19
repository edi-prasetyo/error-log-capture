<?php

namespace EdiPrasetyo\ErrorLogCapture\Console;

use Illuminate\Console\Command;
use EdiPrasetyo\ErrorLogCapture\Models\ErrorLogModel;

class CleanErrorLogs extends Command
{
    protected $signature = 'error-log:clean {--days=30 : Delete logs older than X days}';

    protected $description = 'Clean old error logs from database';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        if ($days <= 0) {
            $this->error('Days must be greater than 0');
            return self::FAILURE;
        }

        $count = ErrorLogModel::where(
            'occurred_at',
            '<',
            now()->subDays($days)
        )->delete();

        $this->info("Deleted {$count} error log(s) older than {$days} days.");

        return self::SUCCESS;
    }
}
