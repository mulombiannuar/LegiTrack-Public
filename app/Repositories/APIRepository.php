<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\APIRepositoryInterface;
use App\Services\APICallService;
use App\Services\LogsService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class APIRepository implements APIRepositoryInterface
{
    protected $logsService;
    protected $apiCallService;

    public function __construct(LogsService $logsService, APICallService $apiCallService)
    {
        $this->logsService = $logsService;
        $this->apiCallService = $apiCallService;
    }

    public function isApiReachable(): bool
    {
        $url = config('app.remote_base_url');
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            $this->logsService->logWarning('Invalid or empty API base URL: ' . $url);
            return false;
        }

        try {
            $client = new Client(['timeout' => 5]);
            $response = $client->request('HEAD', $url);

            return $response->getStatusCode() >= 200 && $response->getStatusCode() < 400;
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            // Log the connection error specifically
            $this->logsService->logError('API Endpoint connection failed: ' . $e->getMessage(), $e);
            return false;
        } catch (RequestException $e) {
            // Handle other types of request errors
            $this->logsService->logError('API Endpoint not reachable: ' . $e->getMessage(), $e);
            return false;
        } catch (\Exception $e) {
            // Catch any other exceptions and log
            $this->logsService->logError('Unexpected error: ' . $e->getMessage(), $e);
            return false;
        }
    }


    public function getParliamentaryHouseTerms(int $houseCategoryId): array
    {
        try {
            return $this->apiCallService->post(
                'api/get-parliamentary-house-terms',
                'Failed to fetch parliamentary terms',
                ['house_category_id' => $houseCategoryId]
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching parliamentary terms: ' . $e->getMessage(), $e);

            return [];
        }
    }

    public function getParliamentaryTermSessions(int $parliamentaryTermId): array
    {
        try {
            return $this->apiCallService->post(
                'api/get-parliamentary-term-sessions',
                'Failed to fetch parliamentary sessions',
                ['parliamentary_term_id' => $parliamentaryTermId]
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching parliamentary term sessions: ' . $e->getMessage(), $e);
            return [];
        }
    }


    public function getBillTypes(): array
    {
        try {
            return $this->apiCallService->get(
                'api/get-bill-types',
                'Failed to fetch bill types'
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching bill types: ' . $e->getMessage(), $e);
            return [];
        }
    }


    public function getBillStages(): array
    {
        try {
            return $this->apiCallService->get(
                'api/get-bill-stages',
                'Failed to fetch bill stages'
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching bill stages: ' . $e->getMessage(), $e);
            return [];
        }
    }


    public function getBillSponsors(): array
    {
        try {
            return $this->apiCallService->get(
                'api/get-bill-sponsors',
                'Failed to fetch bill sponsors'
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching bill sponsors: ' . $e->getMessage(), $e);
            return [];
        }
    }

    public function getBillSponsorshipTypes(): array
    {
        try {
            return $this->apiCallService->get(
                'api/get-sponsorship-types',
                'Failed to fetch bill sponsorship types'
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching bill sponsorship types: ' . $e->getMessage(), $e);
            return [];
        }
    }

    public function getBills(array $params): array
    {
        try {
            return $this->apiCallService->post(
                'api/get-bills',
                'Failed to fetch bills',
                $params
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching bills: ' . $e->getMessage(), $e);
            return [];
        }
    }

    public function getBill(string $slug): array
    {
        try {
            return $this->apiCallService->get(
                "api/get-bills/{$slug}",
                'Failed to fetch bill'
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching bill: ' . $e->getMessage(), $e);
            return [];
        }
    }

    public function getBillCompletedStages(int $bill_id): array
    {
        try {
            return $this->apiCallService->post(
                "api/get-completed-bill-stages",
                'Failed to fetch bill completed stages',
                ['bill_id' => $bill_id]
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching bill completed stages: ' . $e->getMessage(), $e);
            return [];
        }
    }

    public function getBillVersions(int $billId): array
    {
        try {
            return $this->apiCallService->get(
                "api/get-bill-versions/{$billId}",
                'Failed to fetch bill versions'
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching bill versions: ' . $e->getMessage(), $e);
            return [];
        }
    }

    public function getBillVersion(int $billVersionId): array
    {
        try {
            return $this->apiCallService->get(
                "api/get-version-by-id/{$billVersionId}",
                'Failed to fetch bill version details'
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching bill version details: ' . $e->getMessage(), $e);
            return [];
        }
    }

    public function getUserById(int $userId): array
    {
        try {
            return $this->apiCallService->get(
                "api/get-user-by-id/{$userId}",
                'Failed to fetch user details'
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error fetching user details: ' . $e->getMessage(), $e);
            return [];
        }
    }
}
