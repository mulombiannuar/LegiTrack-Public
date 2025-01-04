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
            : null;

        $pageData = array_merge([
            'page_name' => 'pages',
            'title' => 'Search Results',
            'search_query' => $searchQuery,
        ], $this->getPageData());
        //dd($pageData);
        return view('app.pages.search_page', $pageData);
    }

    public function getBillDetails(string $slug) #: View
    {
        $billData = $this->apiService->getBill($slug);
        $billCompletedStages = $this->apiService->getBillCompletedStages($billData['id']);
        $bill = $billData['attributes'];

        if (empty($bill)) {
            abort(404);
        }
        $pageData = [
            'bill' => $billData,
            'page_name' => 'pages',
            'title' => $bill['title'],
            'bill_completed_stages' => $billCompletedStages,
        ];
        return view('app.pages.bill_details_page', $pageData);
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
