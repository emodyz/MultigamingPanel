<?php

namespace App\Jobs;

use App\Models\Server;
use App\Services\Games\GamesStatusService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessServersStatuses implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Execute the job.
   *
   * @return void
   * @throws Exception
   */
  public function handle()
  {
    $gameStatusService = app()->make(GamesStatusService::class);

    Server::chunk(20, function ($servers) use ($gameStatusService) {
      foreach ($servers as $server) {
        $gameStatusService->fetchServerStatus($server);
      }
    });
  }
}
