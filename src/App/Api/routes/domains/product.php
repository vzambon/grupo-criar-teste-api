<?php

use App\Api\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')
->name('products')
->controller(ProductController::class)
->group(function(){
    Route::get('', 'index')->name('.index');
    Route::get('{product}', 'show')->name('.show');
    Route::post('', 'store')->name('.store');
    Route::put('{product}', 'update')->name('.update');
    Route::patch('{product}', 'toggleStatus')->name('.toggle-status');
    Route::delete('{id}', 'destroy')->name('.destroy');
});