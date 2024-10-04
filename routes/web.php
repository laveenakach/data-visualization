<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DataController::class, 'showDashboard']);

Route::get('/data', [DataController::class, 'getData']);
