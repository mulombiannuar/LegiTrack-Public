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

    public function get(string $endPoint, string $errorMsg, ?string $bearerToken = null): array
    {

        try {
            // Prepare headers
            $headers = ['Content-Type' => 'application/json'];
            if ($bearerToken) {
                $headers['Authorization'] = "Bearer $bearerToken";
            }

            // Send request to the API
            $response = $this->client->get(
                "$this->remoteBaseUrl/$endPoint",
                ['headers' => $headers]
            );

            // Decode the response
            $responseData = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200) {
                return [
                    'status' => true,
                    'data' => $responseData['data']
                ];
            }

            // Log and return failure response for non-200 status
            $this->logsService->logError(
                $errorMsg,
                new \Exception("Unexpected status code: {$response->getStatusCode()}")
            );

            return [
                'status' => false,
                'message' => "Unexpected API response: $errorMsg"
            ];
        } catch (\Throwable $e) {
            // Log and return detailed error for exceptions
            $logErrMsg = "Failed to communicate with API endpoint: $endPoint";
            $this->logsService->logError($logErrMsg, $e);

            return [
                'status' => false,
                'message' => $logErrMsg,
                'error' => $e->getMessage()
            ];
        }
    }

    public function post(string $endPoint, string $errorMsg, array $data = [], ?string $bearerToken = null): array
    {
        try {
            // Prepare headers
            $headers = ['Content-Type' => 'application/json', 'Accept' => 'application/json'];
            if ($bearerToken) {
                $headers['Authorization'] = "Bearer $bearerToken";
            }

            // Send POST request
            $response = $this->client->post(
                "$this->remoteBaseUrl/$endPoint",
                [
                    'headers' => $headers,
                    'json' => $data,
                ]
            );

            // Decode the response
            $responseData = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200) {
                return [
                    'status' => true,
                    'data' => $responseData['data']
                ];
            }

            // Handle form validation error (422 Unprocessable Entity)
            if ($response->getStatusCode() === 422) {
                $errors = $responseData['data']['errors'] ?? [];
                $formattedErrors = [];
                foreach ($errors as $field => $messages) {
                    foreach ($messages as $message) {
                        $formattedErrors[] = ucfirst(str_replace('_', ' ', $field)) . ': ' . $message;
                    }
                }

                $this->logsService->logError(
                    $errorMsg,
                    new \Exception("Validation errors: " . implode(', ', $formattedErrors))
                );

                return [
                    'status' => false,
                    'message' => "Form validation failed. Errors: " . implode(', ', $formattedErrors),
                    'errors' => $formattedErrors
                ];
            }

            // Log and return failure response for non-200 and non-422 status
            $this->logsService->logError(
                $errorMsg,
                new \Exception("Unexpected status code: {$response->getStatusCode()}")
            );

            return [
                'status' => false,
                'message' => "Unexpected API response: $errorMsg"
            ];
        } catch (\Throwable $e) {
            // Log and return detailed error for exceptions
            $logErrMsg = "Failed to communicate with API endpoint: $endPoint";
            $this->logsService->logError($logErrMsg, $e);

            return [
                'status' => false,
                'message' => $logErrMsg,
                'error' => $e->getMessage()
            ];
        }
    }

    public function put(string $endPoint, string $errorMsg, array $data = [], ?string $bearerToken = null): array
    {
        try {
            // Prepare headers
            $headers = ['Content-Type' => 'application/json'];
            if ($bearerToken) {
                $headers['Authorization'] = "Bearer $bearerToken";
            }

            // Send PUT request
            $response = $this->client->put(
                "$this->remoteBaseUrl/$endPoint",
                [
                    'headers' => $headers,
                    'json' => $data, // Request body in JSON format
                ]
            );

            // Decode the response
            $responseData = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200) {
                return [
                    'status' => true,
                    'data' => $responseData
                ];
            }

            // Log and return failure response for non-200 status
            $this->logsService->logError(
                $errorMsg,
                new \Exception("Unexpected status code: {$response->getStatusCode()}")
            );

            return [
                'status' => false,
                'message' => "Unexpected API response: $errorMsg"
            ];
        } catch (\Throwable $e) {
            // Log and return detailed error for exceptions
            $logErrMsg = "Failed to communicate with API endpoint: $endPoint";
            $this->logsService->logError($logErrMsg, $e);

            return [
                'status' => false,
                'message' => $logErrMsg,
                'error' => $e->getMessage()
            ];
        }
    }
}
