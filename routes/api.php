<?php

use App\Http\Controllers\VendingController;
use Illuminate\Support\Facades\Route;


Route::get('/machines', [VendingController::class, 'machines']);
Route::post('/machines/{machine}/insert-coin', [VendingController::class, 'insertCoin']);
Route::post('/machines/{machine}/select-product/{product}', [VendingController::class, 'selectProduct']);
Route::post('/machines/{machine}/dispense', [VendingController::class, 'dispense']);
