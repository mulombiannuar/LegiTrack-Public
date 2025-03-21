<?php

use App\Http\Middleware\CheckApiAvailability;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // if (config('app.jwt_auth_enabled')) {
        //     $middleware->api(prepend: [
        //         JwtMiddleware::class,
        //     ]);
        // }

        $middleware->alias([
            'is_admin' => IsAdminMiddleware::class,
            'api.available' => CheckApiAvailability::class,
            'redirect.if.authenticated' => RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
