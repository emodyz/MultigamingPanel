<?php

namespace App\Jobs;

use App\Events\ModPack\ModPackProcessProgress;
use App\Models\Modpack;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
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
        $filePathPrevented = Str::of($filePath)
            ->replace('.', '-');

        Redis::hIncrBy("modpackManifestInfoUpdate:{$this->modpack->id}", 'size', $fileSize);
        Redis::hIncrBy("modpackManifestInfoUpdate:{$this->modpack->id}", 'files', 1);

        Redis::hSet("modpackManifestUpdate:{$this->modpack->id}", $filePathPrevented, json_encode([
            'url' => $fileUrl,
            'size' => $fileSize,
            'name' => $fileName,
            'path' => $filePath,
            'sha256' => $fileHash
        ]));

        ModPackProcessProgress::broadcast($this->modpack, $this->batch()->progress());
    }
}

