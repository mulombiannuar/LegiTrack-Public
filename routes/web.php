<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app.pages.home_page', ['title' => 'Home Page']);
});
Route::get('/login', function () {
    return view('auth.login', ['title' => 'Login']);
});
