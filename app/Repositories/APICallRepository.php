<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\APICallRepositoryInterface;
use App\Services\LogsService;
use GuzzleHttp\Client;

class APICallRepository implements APICallRepositoryInterface
{
    protected $client;
    protected $logsService;
    protected $remoteBaseUrl;

    public function __construct(LogsService $logsService)
    {
        $this->client = new Client();
        $this->logsService = $logsService;
        $this->remoteBaseUrl = config('app.remote_base_url');
    }

    public function get(string $endPoint, string $errorMsg, bool $hasBearerToken = false): array
    {
        try {

            //Send request to remote API
            $bearerToken = '';
            $headers = ['Content-Type'  => 'application/json'];
            if ($hasBearerToken) {
                $headers = array_merge($headers, ['Authorization' => "Bearer $bearerToken"]);
            }

            $response = $this->client->get(
                "$this->remoteBaseUrl/$endPoint",
                ['headers' => $headers]
            );

            // Decode the response data
            $responseData = json_decode($response->getBody()->getContents(), true);

            // Check if the response status is 200 (success)
            if ($response->getStatusCode() == 200) {
                return $responseData;
            } else {

                $this->logsService->logError(
                    $errorMsg,
                    new \Exception('Internal Server error in the API endpoint')
                );

                return [
                    'status' => false,
                    'message' => $errorMsg
                ];
            }
        } catch (\Throwable $e) {
            $logErrMsg = "Error occurred while reaching API endpoint";
            $this->logsService->logError($logErrMsg, $e);
            return [
                'status' => false,
                'message' => $logErrMsg,
                'error' => $e->getMessage()
            ];
        }
    }
}
