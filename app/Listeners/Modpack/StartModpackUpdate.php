<?php

namespace App\Listeners\Modpack;

use App\Events\Modpack\ModpackProcessCanceled;
use App\Events\Modpack\ModpackProcessDone;
use App\Events\Modpack\ModpackProcessFailed;
use App\Events\Modpack\ModpackProcessStarted;
use App\Events\Modpack\ModpackUpdateRequested;
use App\Jobs\ProcessModpackFile;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Throwable;

class StartModpackUpdate implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param ModpackUpdateRequested $event
     * @return bool
     * @throws Throwable
     */
    public function handle(ModpackUpdateRequested $event)
    {
        $modpack = $event->modpack;
        $savedManifest = $modpack->manifest;
        $savedManifestInfo = $modpack->manifest_info;
        $modpack->cleanManifest();

        $files = collect(Storage::disk($modpack->disk)->files($modpack->path, true));
        if ($files->isEmpty()) {
            ModpackProcessDone::broadcast($modpack);
            return true;
        }

        $jobs = $files->map(fn($file) => new ProcessModpackFile($modpack, $file));
        $batch = Bus::batch($jobs->toArray())
            ->then(function (Batch $batch) use ($modpack, $savedManifest, $savedManifestInfo) {
                if ($batch->canceled()) {
                    $modpack->update([
                        'manifest' => $savedManifest,
                        'manifest_info' => $savedManifestInfo
                    ]);
                    ModpackProcessCanceled::broadcast($modpack);
                    return;
                }
                $modpack->update([
                    'manifest_last_update' => now()->toDateTimeString()
                ]);
                ModpackProcessDone::broadcast($modpack);
            })->catch(function () use ($modpack, $savedManifest, $savedManifestInfo) {
                $modpack->update([
                    'manifest' => $savedManifest,
                    'manifest_info' => $savedManifestInfo
                ]);
                ModpackProcessFailed::broadcast($modpack);
            })->finally(function () use ($modpack) {
                $modpack->update([
                    'job_batch_id' => null,
                ]);
            })
            ->name("Modpack update ($modpack->name - $modpack->id)")
            ->dispatch();

        ModpackProcessStarted::broadcast($modpack);
        $modpack->update([
            'job_batch_id' => $batch->id
        ]);
        return true;
    }
}
