<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncIbgeCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-ibge-cities {state_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync IBGE list of cities from a given state to local database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
    }
}
