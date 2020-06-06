<?php

namespace App\Jobs;

use App\Modpack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessModpackManifest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Modpack
     */
    private Modpack $modpack;

    /**
     * Create a new job instance.
     *
     * @param Modpack $modpack
     */
    public function __construct(Modpack $modpack)
    {
        $this->modpack = $modpack;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $path = $this->modpack->path;
        if (!Storage::exists($path)) {
            throw new \Exception("Modpack path not found on localstorage.");
        }


        $now = now();
        $manifestFilePath = "$path-{$now->timestamp}-manifest.json";
        Storage::put($manifestFilePath, '[');

        $files = Storage::files($path, true);
        $fileCount = count($files);

        $startTime = now();


        echo "Generate manifest of $fileCount files\n";

        foreach ($files as $key => $file) {
            $startFile = now();
            $fileName = "TOTO";
            $fileSize = Storage::size($file);
            echo "File size $fileSize of $file\n";
            $hash = hash_file('sha256', storage_path("app/$file"));
            echo "End file size of $file\n";
            echo "Take ". now()->diffAsCarbonInterval($startFile) . "\n";
            $jsonFileSection = json_encode([
                'size' => $fileSize,
                'name' => $fileName,
                'file' => $file,
                'sha256' => $hash
            ]);
            Storage::append(
                $manifestFilePath,
                $key != $fileCount - 1 ?
                    "$jsonFileSection," :
                    "$jsonFileSection"
            );
        }

        echo "Take ". now()->diffAsCarbonInterval($startFile) . "\n";

        Storage::append($manifestFilePath, ']');
        $this->modpack->update([
            'manifest' => $manifestFilePath,
            'manifest_last_update' => $now
        ]);
    }
}
