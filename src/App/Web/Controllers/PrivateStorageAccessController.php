<?php

namespace App\Web\Controllers;

use Illuminate\Support\Facades\Storage;

class PrivateStorageAccessController extends Controller
{
    public function __invoke($disk, $filePath)
    {
        return Storage::disk($disk)->download($filePath);
    }
}
