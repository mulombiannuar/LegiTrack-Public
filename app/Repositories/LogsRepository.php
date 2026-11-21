<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\LogsRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Throwable;

class LogsRepository implements LogsRepositoryInterface
{
    public function logError(string $message, Throwable $e): void
    {
        Log::error($message, ['error' => $e->getMessage(), 'exception' => $e::class]);
    }

    public function logWarning(string $message, array $context = []): void
    {
        Log::warning($message, $context);
    }

    public function logInfo(string $message, array $context = []): void
    {
        Log::info($message, $context);
    }
}
