<?php

namespace App\Jobs;

use App\Events\Modpack\ModpackProcessProgress;
use App\Models\Modpack;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ProcessModpackFile implements ShouldQueue
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
     * @param Modpack $modpack
     * @param string $filePath
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
        if ($this->batch()->cancelled()) {
            return;
        }

        $disk = $this->modpack->disk;

        $filePath = Storage::disk($disk)->path($this->filePath);
        $fileSize = Storage::disk($disk)->size($this->filePath);
        $fileUrl = Storage::disk($disk)->url($this->filePath);
        $fileHash = hash_file('sha256', $filePath);
        $fileName = basename($filePath);
        $filePath = (string)Str::of($this->filePath)->replaceFirst(
            $this->modpack->path,
            $this->modpack->name
        );
        $filePathPrevented = Str::of($filePath)
            ->replace('.', '-');

        $this->modpack->forceFill([
            "manifest_info->size" => $this->modpack->manifest_info['size'] + $fileSize,
            "manifest_info->files" => $this->modpack->manifest_info['files'] + 1,
            "manifest->{$filePathPrevented}" => [
                'url' => $fileUrl,
                'size' => $fileSize,
                'name' => $fileName,
                'path' => $filePath,
                'sha256' => $fileHash
            ]
        ])->saveOrFail();

        ModpackProcessProgress::broadcast($this->modpack, $this->batch()->progress());
    }
}
