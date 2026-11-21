<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\APIRepositoryInterface;

class APIService
{
    public function __construct(
        private readonly APIRepositoryInterface $apiRepository,
    ) {}

    public function isApiReachable(): bool
    {
        return $this->apiRepository->isApiReachable();
    }

    public function getParliamentaryHouseTerms(int $houseCategoryId): array
    {
        return $this->unwrap($this->apiRepository->getParliamentaryHouseTerms($houseCategoryId), 'data');
    }

    public function getParliamentaryTermSessions(int $parliamentaryTermId): array
    {
        return $this->unwrap($this->apiRepository->getParliamentaryTermSessions($parliamentaryTermId), 'data');
    }

    public function getBillTypes(): array
    {
        return $this->unwrap($this->apiRepository->getBillTypes(), 'data.data');
    }

    public function getBillStages(): array
    {
        return $this->unwrap($this->apiRepository->getBillStages(), 'data.data');
    }

    public function getBillSponsors(): array
    {
        return $this->unwrap($this->apiRepository->getBillSponsors(), 'data.data');
    }

    public function getBillSponsorshipTypes(): array
    {
        return $this->unwrap($this->apiRepository->getBillSponsorshipTypes(), 'data.data');
    }

    public function getBills(array $params): array
    {
        return $this->unwrap($this->apiRepository->getBills($params), 'data');
    }

    public function getBill(string $slug): array
    {
        return $this->unwrap($this->apiRepository->getBill($slug), 'data.data');
    }

    public function getBillCompletedStages(int $bill_id): array
    {
        return $this->unwrap($this->apiRepository->getBillCompletedStages($bill_id), 'data.data');
    }

    public function getUserById(int $userId): array
    {
        return $this->apiRepository->getUserById($userId);
    }

    public function getUserPositions(int $userId): array
    {
        return $this->unwrap($this->apiRepository->getUserPositions($userId), 'data');
    }

    public function getBillVersions(int $billId): array
    {
        return $this->apiRepository->getBillVersions($billId);
    }

    public function getBillVersion(int $billVersionId): array
    {
        return $this->apiRepository->getBillVersion($billVersionId);
    }

    public function getHouseCategories(): array
    {
        return $this->unwrap($this->apiRepository->getHouseCategories(), 'data.data');
    }

    public function getCounties(): array
    {
        return $this->unwrap($this->apiRepository->getCounties(), 'data.data');
    }

    public function getSubCounties(int $countyId): array
    {
        return $this->unwrap($this->apiRepository->getSubCounties($countyId), 'data.data');
    }

    public function getWards(int $subCountyId): array
    {
        return $this->unwrap($this->apiRepository->getWards($subCountyId), 'data.data');
    }

    public function submitFeedback(array $data): array
    {
        return $this->apiRepository->submitFeedback($data);
    }

    public function getBillFeedbacks(int $billId, ?int $userId = null): array
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

    public function getAboutStats(): array
    {
        return $this->unwrap($this->apiRepository->getAboutStats(), 'data.data');
    }

    public function saveContact(array $params): array
    {
        return $this->apiRepository->saveContact($params);
    }

    public function getDownload(string $slug): array
    {
        return $this->apiRepository->getDownload($slug);
    }

    /**
     * Read a nested payload from an API envelope, or an empty array when the call
     * failed, so pages render empty sections instead of erroring while LegiTrack is down.
     */
    private function unwrap(array $response, string $path): array
    {
        $value = data_get($response, $path);

        return is_array($value) ? $value : [];
    }
}
