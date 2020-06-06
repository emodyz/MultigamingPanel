<?php

use App\Modpack;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('modpacks:clean', function () {
    if (app()->environment('production')) {
        if (!$this->confirm('Do you wish to continue?')) {
            $this->info('Mission aborted');
            return;
        }
    }
    $this->comment("Cleaning: Oldest Modpacks");

    $inDatabaseDirs = Modpack::pluck('path')->toArray();
    $modpackDirs = collect(Storage::directories('modpacks'));

    /**
     * Reject all in database present paths.
     */
    $modpackDirs = $modpackDirs->reject(function ($value) use ($inDatabaseDirs) {
        return in_array($value, $inDatabaseDirs);
    });

    foreach ($modpackDirs as $directory) {
        Storage::disk('local')->deleteDirectory($directory);
    }
    $this->info('Cleaned: Oldest Modpacks');
});
