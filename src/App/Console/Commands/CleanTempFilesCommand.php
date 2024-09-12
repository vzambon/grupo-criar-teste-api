<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class CleanTempFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:clean-temp-files-command {older_than?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean temporary files older than {older_than} or last hour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $older_than = Carbon::parse($this->argument('older_than')) ?? now()->subHour();

        $files = Storage::drive('temp')->allFiles();

        $deletes = [];

        foreach($files as $file) {
            $lastModified = Carbon::parse(Storage::drive('temp')->lastModified($file));
            if($lastModified->lt($older_than)) {
                $deletes[] = $file;
            }
        }

        Storage::drive('temp')->delete($deletes);
    }
}
