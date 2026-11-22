<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\APIRepositoryInterface;
use App\Services\APICallService;
use App\Services\LogsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * LegiTrack API endpoints used by the public portal. APICallService never throws:
 * each method returns its ['status' => bool, ...] envelope.
 */
class APIRepository implements APIRepositoryInterface
{
    private const REACHABLE_CACHE_KEY = 'legitrack_api_reachable';

    private const REACHABLE_CACHE_SECONDS = 60;

    public function __construct(
        private readonly LogsService $logsService,
        private readonly APICallService $apiCallService,
    ) {}

    /**
     * Probe LegiTrack's /up health route. Only a healthy result is cached, so the
     * portal recovers as soon as LegiTrack does.
     */
    public function isApiReachable(): bool
    {
        if (Cache::get(self::REACHABLE_CACHE_KEY)) {
            return true;
        }

        $url = rtrim((string) config('app.remote_base_url'), '/');
        if ($url === '' || ! filter_var($url, FILTER_VALIDATE_URL)) {
            $this->logsService->logWarning('Invalid or empty API base URL: '.$url);

            return false;
        }

        try {
            $reachable = Http::timeout(5)->head("{$url}/up")->successful();
        } catch (Throwable $e) {
            $this->logsService->logError('API endpoint not reachable: '.$e->getMessage(), $e);

            return false;
        }

        if ($reachable) {
            Cache::put(self::REACHABLE_CACHE_KEY, true, self::REACHABLE_CACHE_SECONDS);
        }

        return $reachable;
    }

    public function getParliamentaryHouseTerms(int $houseCategoryId): array
    {
        return $this->apiCallService->post('api/get-parliamentary-house-terms', 'Failed to fetch parliamentary terms', ['house_category_id' => $houseCategoryId]);
    }

    public function getParliamentaryTermSessions(int $parliamentaryTermId): array
    {
        return $this->apiCallService->post('api/get-parliamentary-term-sessions', 'Failed to fetch parliamentary sessions', ['parliamentary_term_id' => $parliamentaryTermId]);
    }

    public function getBillTypes(): array
    {
        return $this->apiCallService->get('api/get-bill-types', 'Failed to fetch bill types');
    }

    public function getHouseCategories(): array
    {
        return $this->apiCallService->get('api/get-house-categories', 'Failed to fetch house categories');
    }

    public function getBillStages(): array
    {
        return $this->apiCallService->get('api/get-bill-stages', 'Failed to fetch bill stages');
    }

    public function getBillSponsors(): array
    {
        return $this->apiCallService->get('api/get-bill-sponsors', 'Failed to fetch bill sponsors');
    }

    public function getBillSponsorshipTypes(): array
    {
        return $this->apiCallService->get('api/get-sponsorship-types', 'Failed to fetch bill sponsorship types');
    }

    public function getBills(array $params): array
    {
        return $this->apiCallService->post('api/get-bills', 'Failed to fetch bills', $params);
    }

    public function getPublicBills(array $filters): array
    {
        return $this->apiCallService->get('api/public/bills?'.http_build_query($filters), 'Failed to fetch published bills');
    }

    public function getPublicBill(string $slug): array
    {
        return $this->apiCallService->get('api/public/bills/'.rawurlencode($slug), 'Failed to fetch bill');
    }

    public function getBillFollowing(string $slug): array
    {
        return $this->apiCallService->get('api/public/bills/'.rawurlencode($slug).'/following', 'Failed to fetch follow status', session('api_token'));
    }

    public function followBill(string $slug): array
    {
        return $this->apiCallService->post('api/public/bills/'.rawurlencode($slug).'/follow', 'Failed to follow bill', [], session('api_token'));
    }

    public function unfollowBill(string $slug): array
    {
        return $this->apiCallService->delete('api/public/bills/'.rawurlencode($slug).'/follow', 'Failed to unfollow bill', session('api_token'));
    }

    public function unfollowByToken(string $token): array
    {
        return $this->apiCallService->get('api/public/bills/unfollow/'.rawurlencode($token), 'Failed to unsubscribe');
    }

    public function exportPublicBillsCsv(array $filters): ?string
    {
        return $this->apiCallService->getRaw('api/public/bills/export.csv?'.http_build_query($filters), 'Failed to export bills');
    }

    public function getBill(string $slug): array
    {
        return $this->apiCallService->get('api/get-bills/'.rawurlencode($slug), 'Failed to fetch bill');
    }

    public function getBillCompletedStages(int $bill_id): array
    {
        return $this->apiCallService->post('api/get-completed-bill-stages', 'Failed to fetch bill completed stages', ['bill_id' => $bill_id]);
    }

    public function getBillVersions(int $billId): array
    {
        return $this->apiCallService->get("api/get-bill-versions/{$billId}", 'Failed to fetch bill versions');
    }

    public function getBillVersion(int $billVersionId): array
    {
        return $this->apiCallService->get("api/get-version-by-id/{$billVersionId}", 'Failed to fetch bill version details');
    }

    public function getUserById(int $userId): array
    {
        return $this->apiCallService->get("api/get-user-by-id/{$userId}", 'Failed to fetch user details');
    }

    public function getUserPositions(int $userId): array
    {
        return $this->apiCallService->get("api/get-user-positions/{$userId}", 'Failed to fetch user position details');
    }

    public function getCounties(): array
    {
        return $this->apiCallService->get('api/get-counties', 'Failed to fetch counties');
    }

    public function getSubCounties(int $countyId): array
    {
        return $this->apiCallService->post('api/get-sub-counties', 'Failed to fetch subcounties', ['county_id' => $countyId]);
    }

    public function getWards(int $subCountyId): array
    {
        return $this->apiCallService->post('api/get-wards', 'Failed to fetch sub county wards', ['sub_county_id' => $subCountyId]);
    }

    public function submitFeedback(array $params): array
    {
        $params['user_id'] = Auth::id();

        return $this->apiCallService->post('api/save-bill-feedback', 'Failed to submit bill feedback', $params, session('api_token'));
    }

    public function getBillFeedbacks(int $billId, ?int $userId = null): array
    {
        return $this->apiCallService->post("api/get-bill-feedbacks/{$billId}", 'Failed to fetch bill feedbacks', ['user_id' => $userId], session('api_token'));
    }

    public function getPublications(array $params): array
    {
        return $this->apiCallService->post('api/get-bill-publications', 'Failed to fetch bill publications', $params);
    }

    public function getPublication(string $slug): array
    {
        $slug = strtolower($slug);

        return $this->apiCallService->get('api/get-bill-publication/'.rawurlencode($slug), "Failed to fetch bill publication with slug: {$slug}");
    }

    public function getAboutStats(): array
    {
        return $this->apiCallService->get('api/get-about-stats', 'Failed to fetch about us stats');
    }

    public function saveContact(array $params): array
    {
        $params['user_id'] = Auth::id();

        return $this->apiCallService->post('api/save-contact', 'Failed to submit contact details', $params);
    }

    public function getDownload(string $slug): array
    {
        return $this->apiCallService->get('api/get-download/'.rawurlencode($slug), 'Failed to fetch download details');
    }
}
