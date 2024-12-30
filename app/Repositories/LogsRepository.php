<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\LogsRepositoryInterface;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class LogsRepository implements LogsRepositoryInterface
{
    public function logError(string $message, \Throwable $e): void
    {
        $context = [
            'error' => $e->getMessage(),
        ];

        // Check if it's a RequestException
        if ($e instanceof RequestException) {
            $context['request'] = $e->getRequest();
            $context['response'] = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null;
        }

        Log::error($message, $context);
    }

    public function logWarning(string $message, array $context = []): void
    {
        // Log the informational message with context data
        Log::warning($message, $context);
    }

    public function logInfo(string $message, array $context = []): void
    {
        // Log the informational message with context data
        Log::info($message, $context);
    }
}
