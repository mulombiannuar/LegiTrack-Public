<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\APIRepositoryInterface;

class APIService
{
    protected $apiRepository;

    public function __construct(APIRepositoryInterface $apiRepository)
    {
        $this->apiRepository = $apiRepository;
    }

    public function getParliamentaryHouseTerms(int $houseCategoryId): array
    {
        return $this->apiRepository->getParliamentaryHouseTerms($houseCategoryId)['data'];
    }

    public function getParliamentaryTermSessions(int $parliamentaryTermId): array
    {
        return $this->apiRepository->getParliamentaryTermSessions($parliamentaryTermId)['data'];
    }
}
