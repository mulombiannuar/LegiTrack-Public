<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app.pages.home_page', ['title' => 'Home Page']);
});
