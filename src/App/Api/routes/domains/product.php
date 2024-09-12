<?php

use App\Api\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')
    ->name('products')
    ->controller(ProductController::class)
    ->group(function () {
        Route::get('', 'index')->middleware('cached:products')->name('.index');
        Route::get('{product}', 'show')->name('.show');
        Route::post('', 'store')->middleware('cache-forget:products')->name('.store');
        Route::put('{product}', 'update')->middleware('cache-forget:products')->name('.update');
        Route::patch('{product}', 'toggleStatus')->middleware('cache-forget:products')->name('.toggle-status');
        Route::delete('{id}', 'destroy')->name('.destroy');
    });
