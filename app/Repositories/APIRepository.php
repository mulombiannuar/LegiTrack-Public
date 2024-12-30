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

    public function getParliamentaryHouseTerms(int $houseCategoryId): array
    {
        return $this->apiCallService->post(
            'api/get-parliamentary-house-terms',
            'Failed to fetch parliamentary terms',
            ['house_category_id' => $houseCategoryId]
        );
    }

    public function getParliamentaryTermSessions(int $parliamentaryTermId): array
    {
        return $this->apiCallService->post(
            'api/get-parliamentary-term-sessions',
            'Failed to fetch parliamentary sessions',
            ['parliamentary_term_id' => $parliamentaryTermId]
        );
    }
}
