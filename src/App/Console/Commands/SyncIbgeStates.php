<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncIbgeStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-ibge-states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync IBGE list of states to local database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    }
}
