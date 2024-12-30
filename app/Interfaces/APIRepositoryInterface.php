<?php

declare(strict_types=1);

namespace App\Interfaces;

interface APIRepositoryInterface
{
    public function getParliamentaryTerms(): array;
}
