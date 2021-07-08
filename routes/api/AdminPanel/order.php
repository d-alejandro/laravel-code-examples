<?php

use App\Http\Controllers\Api\AdminPanel\Order\DestroyOrderController;
use App\Http\Controllers\Api\AdminPanel\Order\IndexOrderController;
use App\Http\Controllers\Api\AdminPanel\Order\ShowOrderController;
use App\Http\Controllers\Api\AdminPanel\Order\StoreOrderController;
use App\Http\Controllers\Api\AdminPanel\Order\UpdateOrderController;

Route::get('/orders', IndexOrderController::class)->name('adminPanel.order.index');
Route::get('/orders/{id}', ShowOrderController::class)->name('adminPanel.order.show');
Route::post('/orders', StoreOrderController::class)->name('adminPanel.order.store');
Route::put('/orders/{id}', UpdateOrderController::class)->name('adminPanel.order.update');
Route::delete('/orders/{id}', DestroyOrderController::class)->name('adminPanel.order.destroy');
