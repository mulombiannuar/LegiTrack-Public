<?php

namespace App\Http\Middleware;

use App\Services\APIService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class CheckApiAvailability
{
    protected $apiService;

    public function __construct(APIService $apiService)
    {
        $this->apiService = $apiService;
    }
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the API is reachable using the isApiReachable method
        if (!$this->apiService->isApiReachable()) {
            // Redirect to a default page if the API is not reachable
            return Redirect::route('home')
                ->with(
                    'danger',
                    'Service is temporarily unavailable. Please check back soon'
                );
        }

        return $next($request);
    }
}
