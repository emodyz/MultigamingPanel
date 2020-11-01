<?php

namespace App\Console\Commands;

use App\Jobs\ProcessServersStatuses;
use Illuminate\Console\Command;

class ServersStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servers:statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force run ProcessServersStatus job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch_now(new ProcessServersStatuses);

        return 0;
    }
}
