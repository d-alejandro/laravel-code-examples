<?php

use App\Http\Controllers\Api\OrderIndexController;
use Illuminate\Support\Facades\Route;

Route::get('/orders', OrderIndexController::class)->name('order.index');
