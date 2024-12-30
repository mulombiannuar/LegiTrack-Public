<?php

declare(strict_types=1);

namespace App\Interfaces;

interface APICallRepositoryInterface
{
    public function get(string $endPoint, string $errorMsg, bool $hasBearerToken = false): array;
    //public function put(string $endPoint, string $errorMsg, array $options = []): array;
    //public function destroy(string $endPoint, string $errorMsg, array $options = []): array;
}
