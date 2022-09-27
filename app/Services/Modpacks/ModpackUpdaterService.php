<?php

namespace App\Services\Modpacks;

use App\Models\Modpack;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class ModpackUpdaterService
{
    private static function getManifestKey(Modpack $modpack): string
    {
        return "modPack:manifestUpdate:$modpack->id";
    }

    private static function getManifestInfoKey(Modpack $modpack): string
    {
        return "modPack:manifestInfoUpdate:$modpack->id";
    }


    static public function flush(Modpack $modpack): void
    {
        Redis::del(self::getManifestKey($modpack));
        Redis::del(self::getManifestInfoKey($modpack));
    }

    static public function getUpdate(Modpack $modpack): array
    {
        return [
            Redis::hGetAll(self::getManifestKey($modpack)),
            Redis::hGetAll(self::getManifestInfoKey($modpack)),
        ];
    }

    public static function fileProcessed(
        Modpack $modPack,
        string $fileName,
        int $fileSize,
        string $fileUrl,
        string $filePath,
        string $fileHash,
    )
    {
        $manifestKey = self::getManifestKey($modPack);
        $manifestInfoKey = self::getManifestInfoKey($modPack);

        $safeFilePath = Str::of($filePath)
            ->replace('.', '-');


        Redis::hIncrBy($manifestInfoKey, 'size', $fileSize);
        Redis::hIncrBy($manifestInfoKey, 'files', 1);

        Redis::hSet($manifestKey, $safeFilePath, json_encode([
            'url' => $fileUrl,
            'size' => $fileSize,
            'name' => $fileName,
            'path' => $filePath,
            'sha256' => $fileHash
        ]));
    }
}
