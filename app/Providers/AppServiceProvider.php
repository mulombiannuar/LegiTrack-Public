<?php

namespace App\Providers;

use App\Interfaces\APICallRepositoryInterface;
use App\Interfaces\APIRepositoryInterface;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\LogsRepositoryInterface;
use App\Repositories\APICallRepository;
use App\Repositories\APIRepository;
use App\Repositories\AuthRepository;
use App\Repositories\LogsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LogsRepositoryInterface::class, LogsRepository::class);
        $this->app->bind(APIRepositoryInterface::class, APIRepository::class);
        $this->app->bind(APICallRepositoryInterface::class, APICallRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
