<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\APIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class APIController extends Controller
{
    protected $apiService;

    public function __construct(APIService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function getParliamentaryHouseTerms(Request $request): JsonResponse
    {
        $houseCategoryId = (int) $request->house_category_id;
        $parliamentaryTerms = $this->apiService->getParliamentaryHouseTerms(houseCategoryId: $houseCategoryId)['data'];
        $view = view(
            'partials.loaded_parliamentary_terms',
            ['parliamentary_terms' => $parliamentaryTerms]
        )->render();
        return response()->json(['html' => $view]);
    }

    public function getParliamentaryTermSessions(Request $request): JsonResponse
    {
        $parliamentaryTermId = (int) $request->parliamentary_term_id;
        $parliamentarySessions = $this->apiService->getParliamentaryTermSessions($parliamentaryTermId)['data'];
        $view = view(
            'partials.loaded_parliamentary_sessions',
            ['parliamentary_sessions' => $parliamentarySessions]
        )->render();
        return response()->json(['html' => $view]);
    }

    public function getSubCounties(Request $request): JsonResponse
    {
        $countyId = (int) $request->county_id;
        $subCounties = $this->apiService->getSubCounties($countyId);
        $view = view(
            'partials.loaded_sub_counties',
            ['sub_counties' => $subCounties]
        )->render();
        return response()->json(['html' => $view]);
    }

    public function getWards(Request $request): JsonResponse
    {
        $subCountyId = (int) $request->sub_county_id;
        $wards = $this->apiService->getWards($subCountyId);
        $view = view(
            'partials.loaded_wards',
            ['wards' => $wards]
        )->render();
        return response()->json(['html' => $view]);
    }
}
