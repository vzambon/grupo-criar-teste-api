<?php

namespace App\Api\Controllers;

use App\Api\Controllers\Controller;
use Domain\Shared\Actions\SaveTempFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class FileUploadController extends Controller
{
    /**
     * Realiza upload de arquivo
     *
     * @param  mixed $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,csv,jpeg,png|max:2048',
        ]);

        $tempFile = (new SaveTempFile($request->file('file')))->execute();

        return response()->json([
            'filename' => $tempFile->name,
            'temp_url' => URL::signedRoute('private-storage', ['disk' => 'temp', 'filePath' => $tempFile->name], null, false)
        ]);
    }
}
