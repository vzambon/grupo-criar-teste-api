<?php

use App\Api\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

Route::prefix('campaigns')
    ->name('campaigns')
    ->controller(CampaignController::class)
    ->group(function () {
        Route::get('', 'index')->name('.index');
        Route::get('{campaign}', 'show')->name('.show');
        Route::post('', 'store')->name('.store');
        Route::patch('{campaign}', 'toggleStatus')->name('.toggle-status');
        Route::delete('{id}', 'destroy')->name('.destroy');
    });
