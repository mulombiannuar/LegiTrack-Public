<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::controller(PagesController::class)->group(function () {

    Route::controller(APIController::class)
        ->middleware('api.available')
        ->group(function () {
            Route::get('search', 'searchResults')->name('search');
            Route::get('contact-us', 'contactUs')->name('contact-us');
            Route::get('/{slug}', 'getBillDetails')->name('get-bill-details');
        });

    Route::get('/', 'homePage')->name('home');
});

Route::controller(APIController::class)
    ->middleware('api.available')
    ->group(function () {
        Route::post('get-parliamentary-house-terms', 'getParliamentaryHouseTerms')->name('get-parliamentary-house-terms');
        Route::post('get-parliamentary-term-sessions', 'getParliamentaryTermSessions')->name('get-parliamentary-term-sessions');
    });
