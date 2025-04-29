<?php

namespace App\Logging;

use App\Models\Log;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class DatabaseLogger extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        Log::create([
            'level' => $record->level->name,
            'message' => $record->message,
            'context' => $record->context,
            'channel' => $record->channel,
        ]);
    }
}
