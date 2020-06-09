<?php

namespace App\Jobs;

use App\Modpack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessModpackManifest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Modpack
     */
    private Modpack $modpack;

    private $storage;

    private bool $compressFiles = false;

    /**
     * Create a new job instance.
     *
     * @param Modpack $modpack
     */
    public function __construct(Modpack $modpack)
    {
        $this->modpack = $modpack;
        $this->storage = Storage::disk($modpack->disk);
    }


    function taille_fichier($octets)
    {
        $resultat = $octets;
        for ($i = 0; $i < 8 && $resultat >= 1024; $i++) {
            $resultat = $resultat / 1024;
        }
        if ($i > 0) {
            return preg_replace('/,00$/', '', number_format($resultat, 2, ',', ''))
                . ' ' . substr('KMGTPEZY', $i - 1, 1) . 'o';
        } else {
            return $resultat . ' o';
        }
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
        if (!$this->storage->exists($path)) {
            throw new \Exception("Modpack path not found on localstorage.");
        }

        $now = now();
        $manifestFilePath = "$path-{$now->timestamp}-manifest.json";
        $this->storage->put($manifestFilePath, '[');

        $files = $this->storage->files($path, true);
        $filesCount = count($files);
        $filesSize = 0;

        foreach ($files as $key => $file) {
            $filesSize += $this->storage->size($file);
        }

        $startTime = now();

        echo "Generate manifest of $filesCount files\n";
        echo "Total " . $this->taille_fichier($filesSize) . "\n";

        foreach ($files as $key => $file) {
            // FILE INFO
            $fileName = basename($file);
            $fileSize = $this->storage->size($file);
            $filePath = (string)Str::of($file)->replace("$path/", '');
            $localFilePath = $this->storage->path($file);
            echo "File $file - {$this->taille_fichier($fileSize)}\n";

            // HASH
            $startHash = now();
            echo "Start hash $file\n";
            set_time_limit(0);
            $hash = hash_file('sha256', $localFilePath);
            echo "End hash $file take " . now()->diffAsCarbonInterval($startHash) . "\n";

            if ($this->compressFiles) {
                // START ZIP
                $startZip = now();
                echo "Start compressing $file\n";
                $zip = new \ZipArchive();
                $zip->open("$localFilePath.zip", \ZipArchive::CREATE);
                $zip->addFile($localFilePath);
                $zip->close();
                $filePath = "$filePath.zip";
                echo "End zip $file take " . now()->diffAsCarbonInterval($startZip) . "\n";
            }

            $jsonFileSection = json_encode([
                'size' => $fileSize,
                'name' => $fileName,
                'path' => $filePath,
                'url' => $this->storage->url($file),
                'sha256' => $hash
            ]);
            $this->storage->append(
                $manifestFilePath,
                $key != $filesCount - 1 ?
                    "$jsonFileSection," :
                    "$jsonFileSection"
            );
        }

        echo "Total of files take " . now()->diffAsCarbonInterval($startTime) . "\n";

        $this->storage->append($manifestFilePath, ']');
        if ($this->modpack->manifest) {
            $this->storage->delete($this->modpack->manifest);
        }
        $this->modpack->update([
            'manifest' => $manifestFilePath,
            'manifest_last_update' => $now
        ]);
    }
}
