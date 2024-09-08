<?php

use Geolocations\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;

Route::prefix('cities')
->name('cities')
->controller(CityController::class)
->group(function(){
    Route::get('', 'index')->name('.index');
    Route::get('{city}', 'show')->name('.show');
    Route::patch('{city}', 'toggleStatus')->name('.toggle-status');
});