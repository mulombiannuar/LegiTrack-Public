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
}
