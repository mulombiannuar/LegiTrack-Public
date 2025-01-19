<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\APIRepositoryInterface;

class APIService
{
    protected $apiRepository;

    public function isApiReachable(): bool
    {
        return $this->apiRepository->isApiReachable();
    }

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

    public function getBills(array $params): array
    {
        return $this->apiRepository->getBills($params)['data'];
    }

    public function getBill(string $slug): array
    {
        return $this->apiRepository->getBill($slug)['data']['data'];
    }

    public function getBillCompletedStages(int $bill_id): array
    {
        return $this->apiRepository->getBillCompletedStages($bill_id)['data']['data'];
    }

    public function getUserById(int $userId): array
    {
        return $this->apiRepository->getUserById($userId)['data']['data'];
    }

    public function getBillVersions(int $billId): array
    {
        return $this->apiRepository->getBillVersions($billId);
    }

    public function getBillVersion(int $billVersionId): array
    {
        return $this->apiRepository->getBillVersion($billVersionId);
    }

    public function getCounties(): array
    {
        return $this->apiRepository->getCounties()['data']['data'];
    }
    public function getSubCounties(int $countyId): array
    {
        return $this->apiRepository->getSubCounties($countyId)['data']['data'];
    }
    public function getWards(int $subCountyId): array
    {
        return $this->apiRepository->getWards($subCountyId)['data']['data'];
    }
    public function submitFeedback(array $data): array
    {
        return $this->apiRepository->submitFeedback($data);
    }

    public function getBillFeedbacks(int $billId, int $userId = null): array
    {
        return $this->apiRepository->getBillFeedbacks($billId, $userId);
    }

    public function getPublication(string $slug): array
    {
        return $this->apiRepository->getPublication($slug);
    }
    public function getPublications(array $params): array
    {
        return $this->apiRepository->getPublications($params);
    }
}
