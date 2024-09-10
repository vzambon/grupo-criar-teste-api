<?php

use App\Api\Controllers\FileUploadController;
use Illuminate\Support\Facades\Route;

require base_path('/src/App/Api/routes/domains/geolocation.php');
require base_path('/src/App/Api/routes/domains/product.php');
require base_path('/src/App/Api/routes/domains/campaings.php');

Route::post('/file-upload', FileUploadController::class);
