<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

//Auth routes
Route::controller(AuthController::class)
    ->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login')->name('login.store');

        Route::post('logout', 'logout')->name('logout');

        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->name('register.store');

        Route::get('forgot-password', 'showForgotPasswordForm')->name('password.request');
        Route::post('forgot-password', 'sendResetLinkEmail')->name('password.email');

        Route::get('reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
        Route::post('reset-password', 'resetPassword')->name('password.update');
    });

//Pages routes
Route::controller(PagesController::class)->group(function () {

    Route::middleware('api.available')->group(function () {
        Route::get('search', 'searchResults')->name('search');
        Route::get('contact-us', 'contactUs')->name('contact-us');
        Route::get('/{id}/bill-version', 'getBillVersion')->name('bill-version');
        Route::get('/{slug}', 'getBillDetails')->name('get-bill-details');
    });

    Route::get('/', 'homePage')->name('home');
});

//API routes
Route::controller(APIController::class)
    ->middleware('api.available')
    ->group(function () {
        Route::post('get-wards', 'getWards')->name('get-wards');
        Route::post('get-sub-counties', 'getSubCounties')->name('get-sub-counties');
        Route::post('get-parliamentary-house-terms', 'getParliamentaryHouseTerms')->name('get-parliamentary-house-terms');
        Route::post('get-parliamentary-term-sessions', 'getParliamentaryTermSessions')->name('get-parliamentary-term-sessions');
    });
