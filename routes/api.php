<?php

use App\Http\Controllers\VendingController;
use Illuminate\Support\Facades\Route;


Route::get('/status', [VendingController::class, 'status']);
Route::post('/insert-coin', [VendingController::class, 'insertCoin']);
Route::post('/select-product/{product}', [VendingController::class, 'selectProduct']);
