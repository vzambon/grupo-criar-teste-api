<?php

namespace Domain\Shared\Actions;

use Illuminate\Support\Facades\Storage;
use Support\Storage\TempFile;

class PersistTempFile
{
    public function __construct(
        public TempFile $temp,
        public string $toPath,
        public ?string $name = null,
    ) {
    }

    public function execute(): string|false
    {
        $fileName = $this->name ?? $this->temp->name;

        $path = "{$this->toPath}/{$fileName}";

        try {
            if(!Storage::disk('temp')->exists($this->temp->name)){
                throw new \Exception('Failed to move file');
            }

            Storage::disk('private')->put($path, Storage::disk('temp')->get($this->temp->name));
            Storage::disk('temp')->delete($this->temp->name);
        } catch(\Throwable $e) {
            return false;
        }

        return $path;
    }
}
