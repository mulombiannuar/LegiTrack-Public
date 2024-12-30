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
    public function homePage(): View
    {
        $pageData = [
            'page_name' => 'pages',
            'title' => 'Home Page',
        ];
        return view('app.pages.home_page', $pageData);
    }
}
