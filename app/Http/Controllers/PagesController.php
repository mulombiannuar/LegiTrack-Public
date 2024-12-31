<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\APIService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PagesController extends Controller
{
    protected $apiService;

    public function __construct(APIService $apiService)
    {
        $this->apiService = $apiService;
    }
    public function homePage(Request $request): View
    {
        $pageData = [
            'page_name' => 'pages',
            'title' => 'Home Page',
            'bill_types' => $this->apiService->getBillTypes(),
            'bill_stages' => $this->apiService->getBillStages(),
            'bill_sponsors' => $this->apiService->getBillSponsors(),
            'sponsorship_types' => $this->apiService->getBillSponsorshipTypes(),
        ];

        return view('app.pages.home_page', $pageData);
    }
}
