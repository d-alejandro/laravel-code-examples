<?php

use App\Http\Controllers\Api\OrderIndexController;
use App\Http\Controllers\Api\OrderShowController;
use App\Http\Controllers\Api\OrderStoreController;
use Illuminate\Support\Facades\Route;

Route::get('/orders', OrderIndexController::class)->name('order.index');
Route::post('/orders', OrderStoreController::class)->name('order.store');
Route::get('/orders/{id}', OrderShowController::class)->name('order.show');
