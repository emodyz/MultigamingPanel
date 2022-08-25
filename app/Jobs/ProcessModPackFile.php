<?php

namespace App\Jobs;

use App\Events\ModPack\ModPackProcessProgress;
use App\Models\Modpack;
use App\Services\Modpacks\ModpackUpdaterService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ProcessModPackFile implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Modpack
     */
    private Modpack $modpack;
    private string $filePath;

    /**
     * Create a new job instance.
     *
     * @param  Modpack  $modpack
     * @param  string  $filePath
     */
    public function __construct(Modpack $modpack, string $filePath)
    {
        $this->modpack = $modpack;
        $this->filePath = $filePath;
    }


    /**
     * Execute the job.
     *
     * @return void
     * @throws Throwable
     */
    public function handle()
    {
        if ($this->batch()->cancelled() || $this->batch()->hasFailures()) {
            info('Batch canceled or has failures, file skipped '. $this->filePath);
            return;
        }

        info('Processing file '. $this->filePath);

        $disk = $this->modpack->disk;

        $filePath = Storage::disk($disk)->path($this->filePath);
        $fileSize = Storage::disk($disk)->size($this->filePath);
        $fileUrl = Storage::disk($disk)->url($this->filePath);
        $fileHash = hash_file('sha256', $filePath);
        $fileName = basename($filePath);
        $filePath = (string) Str::of($this->filePath)->replaceFirst(
            $this->modpack->path,
            $this->modpack->name
        );

        ModpackUpdaterService::fileProcessed(
            modPack: $this->modpack,
            fileName: $fileName,
            fileSize: $fileSize,
            fileUrl: $fileUrl,
            filePath: $filePath,
            fileHash: $fileHash
        );

        ModPackProcessProgress::broadcast($this->modpack, $this->batch()->progress());
    }
}

