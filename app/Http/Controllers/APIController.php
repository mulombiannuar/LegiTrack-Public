<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmitBillFeedbackRequest;
use App\Http\Requests\SubmitContactRequest;
use App\Services\APIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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

    public function submitBillFeedback(SubmitBillFeedbackRequest $request): RedirectResponse
    {
        $requestData = $request->except(['_method', '_token']);
        $billSubmitted = $this->apiService->submitFeedback($requestData);

        if (!$billSubmitted['status'] || empty($billSubmitted)) {
            return back()->with('warning', "An error has occured while submitting your bill feedback. Please logout and login again to submit your feedback");
        }
        $trackingNumber = $billSubmitted['data']['data']['tracking_number'];
        return back()->with('success', "Your feedback with reference number {$trackingNumber} has been successfully submitted to Parliament for review, and a confirmation email has been sent to you. Thank you for participating in this bill");
    }

    public function submitContact(SubmitContactRequest $request): RedirectResponse
    {
        // Honeypot validation: Reject if the hidden field is filled
        if (!empty($request->address)) {
            return redirect()->back()->with('error', 'Spam detected');
        }

        $requestData = $request->except(['_method', '_token']);
        $contactSubmitted = $this->apiService->saveContact($requestData);

        if (!$contactSubmitted['status'] || empty($contactSubmitted)) {
            return back()->with('warning', "An error has occured while submitting your message. Please try again later");
        }
        return back()->with('success', "Your message has been successfully submitted for review, and a confirmation email has been sent to you.");
    }

    public function updateBillFeedback(Request $request, string $id) {}
    public function deleteBillFeedback(Request $request, string $id) {}
}
