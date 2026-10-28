<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockController;

Route::get('/', [ProductController::class, 'index'])
    ->name('home');

Route::resource('products', ProductController::class);

Route::resource('sales', SaleController::class)
    ->only(['index', 'create', 'store']);

Route::get('/stock', [StockController::class, 'index'])
    ->name('stock.index');

Route::post('/stock', [StockController::class, 'store'])
    ->name('stock.store');