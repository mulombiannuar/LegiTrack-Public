<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\APICallRepositoryInterface;

class APICallService
{
    public function __construct(
        private readonly APICallRepositoryInterface $apiCallRepository,
    ) {}

    public function getRaw(string $endPoint, string $errorMsg): ?string
    {
        return $this->apiCallRepository->getRaw($endPoint, $errorMsg);
    }

    public function get(string $endPoint, string $errorMsg, ?string $bearerToken = null): array
    {
        return $this->apiCallRepository->get($endPoint, $errorMsg, $bearerToken);
    }

    public function post(string $endPoint, string $errorMsg, array $data = [], ?string $bearerToken = null): array
    {
        return $this->apiCallRepository->post($endPoint, $errorMsg, $data, $bearerToken);
    }
}
