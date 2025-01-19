<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SearchBillsRequest;
use App\Services\APIService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class PagesController extends Controller
{
    protected $apiService;

    public function __construct(APIService $apiService)
    {
        $this->apiService = $apiService;
    }
    public function homePage(): View
    {
        $isaApiReachable = $this->apiService->isApiReachable();

        $pageData = [
            'page_name' => 'pages',
            'title' => 'Home Page',
            'is_api_reachable' => $isaApiReachable,
        ];

        if (!$isaApiReachable) {
            return view('app.pages.default_page', $pageData);
        }

        return view(
            'app.pages.home_page',
            array_merge($pageData, $this->getPageData())
        );
    }

    public function searchResults(SearchBillsRequest $request): View
    {
        $searchQuery = ($request->isMethod('get') && count($request->except('_token')) > 0)
            ? $this->makeSearchQuery($request)
            : ['with_html' => true, 'paginate' => 10, 'page' => 1];

        $pageData = array_merge([
            'page_name' => 'pages',
            'title' => 'Search Results',
            'search_query' => $searchQuery,
        ], $this->getPageData());
        //dd($pageData);
        return view('app.pages.search_page', $pageData);
    }

    public function sponsorBills(Request $request): View
    {
        $request->validate([
            'sponsor_id' => 'required|integer|max:11',
        ]);

        $sponsorId = $request->input('sponsor_id');
        $sponsor = $this->apiService->getUserById($sponsorId);

        $title = $sponsor['name'] . ' Sponsored Published Bills';
        $description = "Showing results for published bills sponsored by " . ucwords($sponsor['full_name']);

        $searchQuery = [
            'sponsor_id' => $sponsorId,
            'with_html' => true,
            'paginate' => 10,
            'page' => 1
        ];

        $pageData = [
            'title' => $title,
            'page_name' => 'pages',
            'description' => $description,
            'search_query' => $searchQuery,
        ];
        //dd($pageData);
        return view('app.pages.sponsor_bills_page', $pageData);
    }

    public function getBillDetails(string $slug): View
    {
        $billData = $this->apiService->getBill($slug);
        $billCompletedStages = $this->apiService->getBillCompletedStages($billData['id']);
        $bill = $billData['attributes'];

        if (empty($bill)) {
            abort(404);
        }

        $billId = (int) $billData['id'];

        $billSponsor = $this->apiService->getUserById($bill['sponsor_id']);

        $billVersionsData = $this->apiService->getBillVersions($billId);
        $billVersions = $billVersionsData['status'] ? $billVersionsData['data']['data'] : [];

        $billFeedbacks = $this->apiService->getBillFeedbacks($billId, userId());
        $billFeedbacks = $billFeedbacks['status'] ? $billFeedbacks['data']['data'] : [];

        //dd($billFeedbacks);

        $pageData = [
            'bill' => $billData,
            'page_name' => 'pages',
            'title' => $bill['title'],
            'bill_sponsor' => $billSponsor,
            'bill_versions' => $billVersions,
            'bill_feedbacks' => $billFeedbacks,
            'bill_completed_stages' => $billCompletedStages,
        ];
        return view('app.pages.bill_details_page', $pageData);
    }

    public function getBillVersion(int $billVersionId): View
    {
        $billVersionData = $this->apiService->getBillVersion($billVersionId);
        $billVersion = $billVersionData['status'] ? $billVersionData['data']['data'] : [];
        $title = $billVersionData['status']
            ? $billVersion['bill_title'] . ' Bill Version ' . $billVersion['version_number']
            : 'Bill Version Details Not Found';

        $pageData = [
            'page_name' => 'pages',
            'title' => $title,
            'bill_version' => $billVersion
        ];
        return view('app.pages.bill_version_page', $pageData);
    }

    public function media(): View
    {
        $pageData = [
            'page_name' => 'pages',
            'title' => 'News & Publications',
        ];
        return view('app.pages.media_page', $pageData);
    }

    public function getMediaBySlug(string $slug): View
    {
        $publicationData = $this->apiService->getPublication($slug);
        $publication = $publicationData['status'] ? $publicationData['data']['data'] : [];
        $title = $publicationData['status'] ? $publication['title']  : 'Publication not found';

        $pageData = [
            'title' => $title,
            'page_name' => 'pages',
            'publication' => $publication
        ];
        return view('app.pages.single_media_page', $pageData);
    }


    private function getPageData(): array
    {
        return [
            'bill_types' => $this->apiService->getBillTypes(),
            'bill_stages' => $this->apiService->getBillStages(),
            'bill_sponsors' => $this->apiService->getBillSponsors(),
            'sponsorship_types' => $this->apiService->getBillSponsorshipTypes(),
        ];
    }

    private function makeSearchQuery(Request $request): array
    {
        return [
            "search" => $request->input('search', null),
            "parliamentary_term_id" => $request->input('parliamentary_term_id', null),
            "parliamentary_session_id" => $request->input('parliamentary_session_id', null),
            "bill_type_id" => $request->input('bill_type_id', null),
            "bill_stage_id" => $request->input('bill_stage_id', null),
            "sponsorship_type_id" => $request->input('sponsorship_type_id', null),
            "sponsor_id" => $request->input('sponsor_id', null),
            "paginate" => $request->input('paginate', 10),
            "page" => $request->input('page', 1),
            'with_html' => $request->input('with_html', true),
        ];
    }
}
