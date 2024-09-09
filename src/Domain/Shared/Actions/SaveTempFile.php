<?php

namespace Domain\Shared\Actions;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Support\Storage\TempFile;

class SaveTempFile
{
    public function __construct(public UploadedFile|File $file)
    {
    }

    public function execute(): TempFile|false
    {
        $tempFile = TempFile::fromFile($this->file);

        if (Storage::disk('temp')->put($tempFile->name, $this->file)) {
            return $tempFile;
        }

        return false;
    }
}
