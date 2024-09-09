<?php

use App\Web\Controllers\PrivateStorageAccessController;
use Illuminate\Support\Facades\Route;

Route::middleware(['signed:relative'])
    ->get('private-storage/{disk}/{filePath}', PrivateStorageAccessController::class)
    ->where('filePath', '.*')
    ->name('private-storage');
