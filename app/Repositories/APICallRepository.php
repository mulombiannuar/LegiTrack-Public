<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\APICallRepositoryInterface;
use App\Services\LogsService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

/**
 * HTTP client for LegiTrack's API. Every call returns
 * ['status' => true, 'data' => ...] or ['status' => false, 'message' => ..., ...]; it never throws.
 */
class APICallRepository implements APICallRepositoryInterface
{
    private const TIMEOUT_SECONDS = 15;

    public function __construct(
        private readonly LogsService $logsService,
    ) {}

    public function get(string $endPoint, string $errorMsg, ?string $bearerToken = null): array
    {
        return $this->request('get', $endPoint, $errorMsg, [], $bearerToken);
    }

    public function getRaw(string $endPoint, string $errorMsg): ?string
    {
        try {
            $response = $this->client(null)->accept('*/*')->get($endPoint);
        } catch (Throwable $e) {
            $this->logsService->logError($errorMsg, $e);

            return null;
        }

        return $response->successful() ? $response->body() : null;
    }

    public function post(string $endPoint, string $errorMsg, array $data = [], ?string $bearerToken = null): array
    {
        return $this->request('post', $endPoint, $errorMsg, $data, $bearerToken);
    }

    public function put(string $endPoint, string $errorMsg, array $data = [], ?string $bearerToken = null): array
    {
        return $this->request('put', $endPoint, $errorMsg, $data, $bearerToken);
    }

    private function request(string $method, string $endPoint, string $errorMsg, array $data, ?string $bearerToken): array
    {
        try {
            $response = $this->client($bearerToken)->{$method}($endPoint, $method === 'get' ? null : $data);
        } catch (Throwable $e) {
            $message = "Failed to communicate with API endpoint: {$endPoint}";
            $this->logsService->logError($message, $e);

            return ['status' => false, 'message' => $message, 'error' => $e->getMessage()];
        }

        if ($response->successful()) {
            // PUT callers historically received the whole body; GET/POST callers receive its "data" member.
            return ['status' => true, 'data' => $method === 'put' ? $response->json() : ($response->json('data') ?? [])];
        }

        if ($response->status() === 422) {
            return $this->validationFailure($response, $errorMsg);
        }

        $detail = "Unexpected status code {$response->status()} from {$endPoint}: ".$response->json('message', '');

        // 4xx answers (not found, unauthenticated) are normal outcomes; only server failures are errors
        $response->clientError()
            ? $this->logsService->logWarning("{$errorMsg}. {$detail}")
            : $this->logsService->logError($errorMsg, new RuntimeException($detail));

        return ['status' => false, 'message' => "Unexpected API response: {$errorMsg}"];
    }

    private function client(?string $bearerToken): PendingRequest
    {
        return Http::baseUrl(rtrim((string) config('app.remote_base_url'), '/'))
            ->acceptJson()
            ->asJson()
            ->timeout(self::TIMEOUT_SECONDS)
            ->when($bearerToken, fn (PendingRequest $request) => $request->withToken($bearerToken));
    }

    private function validationFailure(Response $response, string $errorMsg): array
    {
        $errors = [];
        foreach ((array) $response->json('data.errors', []) as $field => $messages) {
            foreach ((array) $messages as $message) {
                $errors[] = ucfirst(str_replace('_', ' ', (string) $field)).': '.$message;
            }
        }

        $this->logsService->logError($errorMsg, new RuntimeException('Validation errors: '.implode(', ', $errors)));

        return [
            'status' => false,
            'message' => 'Form validation failed. Errors: '.implode(', ', $errors),
            'errors' => $errors,
        ];
    }
}
