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

    public function getBillTypes(): array
    {
        return $this->apiRepository->getBillTypes()['data']['data'];
    }

    public function getBillStages(): array
    {
        return $this->apiRepository->getBillStages()['data']['data'];
    }

    public function getBillSponsors(): array
    {
        return $this->apiRepository->getBillSponsors()['data']['data'];
    }

    public function getBillSponsorshipTypes(): array
    {
        return $this->apiRepository->getBillSponsorshipTypes()['data']['data'];
    }
}
