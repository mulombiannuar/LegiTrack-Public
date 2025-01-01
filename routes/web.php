<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::controller(PagesController::class)->group(function () {
    Route::get('/{slug}', 'getBillDetails')->name('get-bill-details');
    Route::get('/', 'homePage')->name('home');
});

Route::controller(APIController::class)->group(function () {
    Route::post('get-parliamentary-house-terms', 'getParliamentaryHouseTerms')->name('get-parliamentary-house-terms');
    Route::post('get-parliamentary-term-sessions', 'getParliamentaryTermSessions')->name('get-parliamentary-term-sessions');
});
