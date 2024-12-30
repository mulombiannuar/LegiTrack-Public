<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\LogsRepositoryInterface;

class LogsService
{
    protected $logsRepository;

    public function __construct(LogsRepositoryInterface $logsRepository)
    {
        $this->logsRepository = $logsRepository;
    }

    public function logError(string $message, \Throwable $e): void
    {
        $this->logsRepository->logError($message, $e);
    }

    public function logInfo(string $message, array $context = []): void
    {
        $this->logsRepository->logInfo($message, $context);
    }

    public function logWarning(string $message, array $context = []): void
    {
        $this->logsRepository->logWarning($message, $context);
    }
}
