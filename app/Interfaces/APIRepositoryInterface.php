<?php

declare(strict_types=1);

namespace App\Interfaces;

interface APIRepositoryInterface
{
    public function isApiReachable(): bool;
    public function getParliamentaryHouseTerms(int $houseCategoryId): array;
    public function getParliamentaryTermSessions(int $parliamentaryTermId): array;
    public function getBillTypes(): array;
    public function getHouseCategories(): array;
    public function getBillStages(): array;
    public function getBillSponsors(): array;
    public function getBillSponsorshipTypes(): array;
    public function getBills(array $params): array;
    public function getBill(string $slug): array;
    public function getUserPositions(int $userId): array;
    public function getBillCompletedStages(int $bill_id): array;
    public function getUserById(int $userId): array;
    public function getBillVersions(int $billId): array;
    public function getBillVersion(int $billVersionId): array;
    public function getCounties(): array;
    public function getSubCounties(int $countyId): array;
    public function getWards(int $subCountyId): array;
    public function submitFeedback(array $data): array;
    public function getBillFeedbacks(int $billId, int $userId = null): array;
    public function getPublication(string $slug): array;
    public function getPublications(array $params): array;
    public function getAboutStats(): array;
    public function saveContact(array $params): array;
    public function getDownload(string $slug): array;
}
