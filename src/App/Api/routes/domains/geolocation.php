<?php

use App\Api\Controllers\CityController;
use App\Api\Controllers\ClusterController;
use App\Api\Controllers\StateController;
use Illuminate\Support\Facades\Route;

Route::prefix('cities')
    ->name('cities')
    ->controller(CityController::class)
    ->group(function () {
        Route::get('', 'index')->middleware('cached:cities')->name('.index');
        Route::get('{city}', 'show')->name('.show');
        Route::patch('{city}', 'toggleStatus')->middleware('cache-forget:cities')->name('.toggle-status');
    });

Route::prefix('states')
    ->name('states')
    ->controller(StateController::class)
    ->group(function () {
        Route::get('', 'index')->middleware('cached:states')->name('.index');
        Route::get('{state}', 'show')->name('.show');
        Route::patch('{state}', 'toggleStatus')->middleware('cache-forget:states')->name('.toggle-status');
    });

Route::prefix('clusters')
    ->name('clusters')
    ->controller(ClusterController::class)
    ->group(function () {
        Route::get('', 'index')->name('.index');
        Route::get('{cluster}/campaign', 'showCampaign')->name('.campaign');
        Route::get('{cluster}', 'show')->name('.show');
        Route::patch('{cluster}', 'toggleStatus')->name('.toggle-status');
        Route::post('', 'store')->name('.store');
        Route::delete('{id}', 'destroy')->name('.destroy');
    });
