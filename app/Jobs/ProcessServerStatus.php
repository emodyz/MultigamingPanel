<?php

namespace App\Jobs;

use App\Models\Server;
use App\Services\Games\GamesStatusService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessServerStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Server $server;

    /**
     * ProcessServerStatus constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Execute the job.
     * @return void
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function handle()
    {
        $gameStatusService = app()->make(GamesStatusService::class);

        $gameStatusService->fetchServerStatus($this->server);
    }
}
