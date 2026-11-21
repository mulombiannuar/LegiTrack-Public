<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Services\APICallService;
use App\Services\LogsService;
use Illuminate\Support\Facades\Auth;

/**
 * Accounts live in LegiTrack; the portal authenticates through its API and keeps
 * the returned Sanctum token in the session for authenticated calls.
 */
class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(
        private readonly LogsService $logsService,
        private readonly APICallService $apiCallService,
    ) {}

    public function login(array $userData): array
    {
        return $this->apiCallService->post('api/login', 'Failed to login user', $userData);
    }

    public function register(array $userData): array
    {
        return $this->apiCallService->post('api/register', 'Failed to register new user', $userData);
    }

    public function sendResetLinkEmail(array $requestData): bool
    {
        $response = $this->apiCallService->post('api/send-password-link', 'Failed to send password reset link', $requestData);

        return $this->succeeded($response, 'Failed to send password reset link.');
    }

    public function updatePassword(array $requestData): bool
    {
        $response = $this->apiCallService->post('api/update-password', 'Failed to update user password', $requestData);

        return $this->succeeded($response, 'Failed to update user password.');
    }

    public function logout(): bool
    {
        $token = session('api_token');

        if ($token) {
            $response = $this->apiCallService->post('api/logout', 'Failed to logout user', bearerToken: $token);

            $response['status']
                ? $this->logsService->logInfo('User token revoked successfully.')
                : $this->logsService->logWarning('Failed to revoke token at the API.');
        }

        // Always end the local session, even if LegiTrack could not revoke the token
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return true;
    }

    private function succeeded(array $response, string $warning): bool
    {
        if (! $response['status']) {
            $this->logsService->logWarning($warning);
        }

        return $response['status'];
    }
}
