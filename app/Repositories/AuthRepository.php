<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Services\APICallService;
use App\Services\LogsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class AuthRepository implements AuthRepositoryInterface
{
    protected $logsService;
    protected $apiCallService;

    public function __construct(LogsService $logsService, APICallService $apiCallService)
    {
        $this->logsService = $logsService;
        $this->apiCallService = $apiCallService;
    }
    public function login(array $userData): array
    {
        try {
            return $this->apiCallService->post(
                'api/login',
                'Failed to login new user',
                $userData
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error while logging new user: ' . $e->getMessage(), $e);

            return [];
        }
    }

    public function register(array $userData): array
    {
        try {
            return $this->apiCallService->post(
                'api/register',
                'Failed to register new user',
                $userData
            );
        } catch (\Exception $e) {
            $this->logsService->logError('Error while registering new user: ' . $e->getMessage(), $e);

            return [];
        }
    }
    public function sendResetLinkEmail(array $requestData): bool
    {
        try {
            $response = $this->apiCallService->post(
                endPoint: 'api/send-password-link',
                errorMsg: 'Failed to send password reset link',
                data: $requestData
            );
            if (!$response['status']) {
                $this->logsService->logWarning('Failed to send password reset link.');
                return false;
            }
            return true;
        } catch (\Exception $e) {
            $this->logsService->logError('Error while sending password reset link: ' . $e->getMessage(), $e);
            return false;
        }
    }
    public function updatePassword(array $requestData): bool
    {
        try {
            $response = $this->apiCallService->post(
                endPoint: 'api/update-password',
                errorMsg: 'Failed to update user password',
                data: $requestData
            );
            if (!$response['status']) {
                $this->logsService->logWarning('Failed to update user password.');
                return false;
            }
            return true;
        } catch (\Exception $e) {
            $this->logsService->logError('Error while updating user password: ' . $e->getMessage(), $e);
            return false;
        }
    }

    public function logout(): bool
    {
        try {
            // Get the API token from the session
            $token = session('api_token');

            if ($token) {
                // Revoke the token in the API
                $response = $this->apiCallService->post(
                    endPoint: 'api/logout',
                    errorMsg: 'Failed to logout user',
                    bearerToken: $token
                );

                if ($response['status']) {
                    // Log success and remove the token from the session
                    $this->logsService->logInfo('User token revoked successfully.');
                } else {
                    $this->logsService->logWarning('Failed to revoke token at the API.');
                }
            }

            // Clear session and log the user out of the client application
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return true;
        } catch (\Exception $e) {
            // Log the error and return false
            $this->logsService->logError('Error while logging out user: ' . $e->getMessage(), $e);
            return false;
        }
    }
}
