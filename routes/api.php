<?php

use App\Http\Controllers\Api\IndexOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/orders', IndexOrderController::class)->name('adminPanel.order.index');
