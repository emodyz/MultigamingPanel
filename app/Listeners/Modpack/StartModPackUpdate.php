<?php

namespace App\Listeners\Modpack;

use App\Events\ModPack\ModPackProcessCanceled;
use App\Events\ModPack\ModPackProcessDone;
use App\Events\ModPack\ModPackProcessFailed;
use App\Events\ModPack\ModPackProcessStarted;
use App\Events\ModPack\ModPackUpdateRequested;
use App\Jobs\ProcessModPackFile;
use App\Services\Modpacks\ModpackUpdaterService;
use Exception;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class StartModPackUpdate implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param ModPackUpdateRequested $event
     * @return bool
     * @throws Throwable
     */
    public function handle(ModPackUpdateRequested $event)
    {
        $modpack = $event->modPack;

        $files = collect(Storage::disk($modpack->disk)->files($modpack->path, true));
        if ($files->isEmpty()) {
            ModPackProcessDone::broadcast($modpack);
            return true;
        }

        ModpackUpdaterService::flush($modpack);

        $jobs = $files->map(fn($file) => new ProcessModPackFile($modpack, $file));
        $batch = Bus::batch($jobs->toArray())
            ->then(function (Batch $batch) use ($modpack) {
                if ($batch->canceled()) {
                    ModPackProcessCanceled::broadcast($modpack);
                    return;
                }

                [$manifest, $manifestInfo] = ModpackUpdaterService::getUpdate($modpack);

                if (!empty($manifest) && !empty($manifestInfo)) {
                    $modpack->update([
                        'manifest' => collect($manifest)->map(fn ($value) => json_decode($value)),
                        'manifest_info' => $manifestInfo,
                        'manifest_last_update' => now()->toDateTimeString()
                    ]);
                    ModPackProcessDone::broadcast($modpack);
                    Log::info('Job done');
                    return;
                }

                throw new Exception('Job not finalized correctly...');
            })->catch(function () use ($modpack) {
                ModPackProcessFailed::broadcast($modpack);
                Log::alert('Job failed');
            })->finally(function () use ($modpack) {
                $modpack->update([
                    'job_batch_id' => null,
                ]);
            })
            ->name("Modpack update ($modpack->name - $modpack->id)")
            ->dispatch();

        ModPackProcessStarted::broadcast($modpack);
        $modpack->update([
            'job_batch_id' => $batch->id
        ]);
        return true;
    }
}
