<?php

namespace Support\Storage;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TempFile
{
    public string $path;

    public function __construct(
        public string $name,
        public ?string $mime = null,
    ) {
        $this->path = "temp/{$this->name}";
    }

    public static function fromFile(UploadedFile|File $file)
    {
        return new self(
            $file->getFilename(),
            $file->getMimeType(),
        );
    }

    public function get(): ?string
    {
        return Storage::disk('temp')->get("{$this->name}");
    }
}
