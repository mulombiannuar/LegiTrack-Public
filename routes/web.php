<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'homePage'])->name('home');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

//Auth routes
Route::middleware('redirect.if.authenticated')->group(function () {

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.store');

    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.store');

    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
});

//Pages routes
Route::controller(PagesController::class)
    ->middleware('api.available')
    ->group(function () {

        Route::get('search', 'searchResults')->name('search');
        Route::get('contact-us', 'contactUs')->name('contact-us');
        Route::get('media', 'media')->name('media');
        Route::get('about-us', 'aboutPage')->name('about-us');
        Route::get('media/{slug}', 'getMediaBySlug')->name('get-media');
        Route::get('/{id}/bill-version', 'getBillVersion')->name('bill-version');
        Route::get('/{slug}', 'getBillDetails')->name('get-bill-details');
    });

//API routes
Route::controller(APIController::class)
    ->middleware('api.available')
    ->group(function () {

        Route::post('get-wards', 'getWards')->name('get-wards');
        Route::post('get-sub-counties', 'getSubCounties')->name('get-sub-counties');
        Route::post('get-parliamentary-house-terms', 'getParliamentaryHouseTerms')->name('get-parliamentary-house-terms');
        Route::post('get-parliamentary-term-sessions', 'getParliamentaryTermSessions')->name('get-parliamentary-term-sessions');

        //logged in routes
        Route::middleware('auth')->group(function () {
            Route::post('submit-bill-feedback', 'submitBillFeedback')->name('submit-bill-feedback');
            Route::put('update-bill-feedback/{id}', 'updateBillFeedback')->name('update-bill-feedback');
            Route::delete('delete-bill-feedback/{id}', 'deleteBillFeedback')->name('delete-bill-feedback');
        });
    });
