<?php

declare(strict_types=1);

namespace App\Interfaces;

interface LogsRepositoryInterface
{
    public function logError(string $message, \Throwable $e): void;
    public function logInfo(string $message, array $context = []): void;
    public function logWarning(string $message, array $context = []): void;
}
