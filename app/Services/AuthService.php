<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\AuthRepositoryInterface;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(array $userData): array
    {
        return $this->authRepository->login($userData);
    }

    public function register(array $userData): array
    {
        return $this->authRepository->register($userData);
    }

    public function logout(): bool
    {
        return $this->authRepository->logout();
    }
}
