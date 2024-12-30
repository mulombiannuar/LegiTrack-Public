<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\APIRepositoryInterface;
use App\Services\APICallService;
use App\Services\LogsService;

class APIRepository implements APIRepositoryInterface
{
    protected $logsService;
    protected $apiCallService;

    public function __construct(LogsService $logsService, APICallService $apiCallService)
    {
        $this->logsService = $logsService;
        $this->apiCallService = $apiCallService;
    }

    public function getParliamentaryTerms(): array
    {
        $endPoint = 'api/get-parliamentary-terms';
        $errMsg = 'Failed to fetch parliamentary terms';
        return $this->apiCallService->get($endPoint, $errMsg);
    }
}
