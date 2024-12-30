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

    public function getParliamentaryTerms(): array
    {
        return $this->apiRepository->getParliamentaryTerms();
    }
}
