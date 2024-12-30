<?php

declare(strict_types=1);

namespace App\Interfaces;

interface APICallRepositoryInterface
{
    public function get(string $endPoint, string $errorMsg, ?string $bearerToken = null): array;
    public function post(string $endPoint, string $errorMsg, array $data = [], ?string $bearerToken = null): array;
    public function put(string $endPoint, string $errorMsg, array $data = [], ?string $bearerToken = null): array;
    //public function destroy(string $endPoint, string $errorMsg, array $options = []): array;
}
