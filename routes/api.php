<?php

use App\Http\Controllers\VendingMachineController;
use Illuminate\Support\Facades\Route;


Route::get('/status', [VendingMachineController::class, 'status']);
Route::post('/insert-coin', [VendingMachineController::class, 'insertCoin']);
Route::post('/select-product/{product}', [VendingMachineController::class, 'selectProduct']);
