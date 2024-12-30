<?php

namespace App\Providers;

use App\Repositories\APIRepository;
use App\Repositories\LogsRepository;
use App\Repositories\APICallRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\APIRepositoryInterface;
use App\Interfaces\LogsRepositoryInterface;
use App\Interfaces\APICallRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogsRepositoryInterface::class, LogsRepository::class);
        $this->app->bind(APIRepositoryInterface::class, APIRepository::class);
        $this->app->bind(APICallRepositoryInterface::class, APICallRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
