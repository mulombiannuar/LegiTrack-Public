<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\APICallRepositoryInterface;

class APICallService
{
    protected $apiCallRepository;

    public function __construct(APICallRepositoryInterface $apiCallRepository)
    {
        $this->apiCallRepository = $apiCallRepository;
    }

    public function get(string $endPoint, string $errorMsg, bool $hasBearerToken = false): array
    {
        return $this->apiCallRepository->get($endPoint, $errorMsg, $hasBearerToken);
    }
}
