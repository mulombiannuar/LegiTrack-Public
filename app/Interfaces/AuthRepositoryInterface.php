<?php

declare(strict_types=1);

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function login(array $userData): array;
    public function register(array $userData): array;
    public function sendResetLinkEmail(array $requestData): bool;
    public function updatePassword(array $requestData): bool;
    public function logout(): bool;
}
