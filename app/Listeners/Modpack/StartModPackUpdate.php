<?php

namespace App\Listeners\Modpack;

use App\Events\ModPack\ModPackProcessCanceled;
use App\Events\ModPack\ModPackProcessDone;
use App\Events\ModPack\ModPackProcessFailed;
use App\Events\ModPack\ModPackProcessStarted;
use App\Events\ModPack\ModPackUpdateRequested;
use App\Jobs\ProcessModPackFile;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
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
        $savedManifest = $modpack->manifest;
        $savedManifestInfo = $modpack->manifest_info;
        $modpack->cleanManifest();

        $files = collect(Storage::disk($modpack->disk)->files($modpack->path, true));
        if ($files->isEmpty()) {
            ModPackProcessDone::broadcast($modpack);
            return true;
        }

        $jobs = $files->map(fn($file) => new ProcessModPackFile($modpack, $file));
        $batch = Bus::batch($jobs->toArray())
            ->then(function (Batch $batch) use ($modpack, $savedManifest, $savedManifestInfo) {
                if ($batch->canceled()) {
                    $modpack->update([
                        'manifest' => $savedManifest,
                        'manifest_info' => $savedManifestInfo
                    ]);
                    ModPackProcessCanceled::broadcast($modpack);
                    return;
                }
                $modpack->update([
                    'manifest_last_update' => now()->toDateTimeString()
                ]);
                ModPackProcessDone::broadcast($modpack);
            })->catch(function () use ($modpack, $savedManifest, $savedManifestInfo) {
                $modpack->update([
                    'manifest' => $savedManifest,
                    'manifest_info' => $savedManifestInfo
                ]);
                ModPackProcessFailed::broadcast($modpack);
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
