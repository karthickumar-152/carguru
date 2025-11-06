<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bidding-settings', function () {
    return view('bidding-settings');
});

