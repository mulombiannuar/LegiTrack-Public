<?php

declare(strict_types=1);

namespace App\Interfaces;

interface APIRepositoryInterface
{
    public function getParliamentaryHouseTerms(int $houseCategoryId): array;
    public function getParliamentaryTermSessions(int $parliamentaryTermId): array;
}
