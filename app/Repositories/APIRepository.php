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

    public function getBillTypes(): array
    {
        return $this->apiCallService->get(
            'api/get-bill-types',
            'Failed to fetch bill types',
        );
    }

    public function getBillStages(): array
    {
        return $this->apiCallService->get(
            'api/get-bill-stages',
            'Failed to fetch bill stages',
        );
    }

    public function getBillSponsors(): array
    {
        return $this->apiCallService->get(
            'api/get-bill-sponsors',
            'Failed to fetch bill sponsors',
        );
    }

    public function getBillSponsorshipTypes(): array
    {
        return $this->apiCallService->get(
            'api/get-sponsorship-types',
            'Failed to fetch bill sponsorship types',
        );
    }

    public function getBills(array $params): array
    {
        return $this->apiCallService->post(
            'api/get-bills',
            'Failed to fetch bills',
            $params
        );
    }


    public function getBill(string $slug): array
    {
        return $this->apiCallService->post(
            'api/get-bill',
            'Failed to fetch bill',
            ['slug' => $slug]
        );
    }
}
