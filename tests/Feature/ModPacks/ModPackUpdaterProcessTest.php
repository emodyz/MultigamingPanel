<?php

namespace Tests\Feature\ModPacks;

use App\Events\ModPack\ModPackProcessDone;
use App\Events\ModPack\ModPackProcessProgress;
use App\Events\ModPack\ModPackProcessStarted;
use App\Events\ModPack\ModPackUpdateRequested;
use App\Jobs\ProcessModPackFile;
use App\Listeners\Modpack\StartModPackUpdate;
use App\Models\Modpack;
use Illuminate\Bus\PendingBatch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ModPackUpdaterProcessTest extends TestCase
{

    const FILE_1MB_URL = 'https://github.com/emodyz/SpeedTest/blob/master/1MB.bin?raw=true';
    const FILE_1MB_SHA256 = '8c3add6c443e009d32da6d96161cb9254f8309ace39fbf5c9bd58f18ad86fed2';
    const FILE_1MB_SIZE = 1000000;

    const FILE_10MB_URL = 'https://github.com/emodyz/SpeedTest/blob/master/10MB.bin?raw=true';
    const FILE_10MB_SHA256 = '97a9371082314da9d92f71e285d454d9639218c517e3ba164429489af6573be5';
    const FILE_10MB_SIZE = 10000000;

    /**
     * @test
     */
    public function assert_that_modpack_update_request_start_modpack_update()
    {
        $modPack = Modpack::factory()->create();

        $spy = $this->spy(StartModPackUpdate::class);

        ModPackUpdateRequested::broadcast($modPack);

        $spy->shouldHaveReceived('handle');
    }

    /**
     * @test
     */
    public function assert_modpacks_update_without_files_must_be_done()
    {
        $modPack = Modpack::factory()->create();

        Event::fake([
            ModPackProcessDone::class,
            ModPackProcessStarted::class
        ]);

        ModPackUpdateRequested::broadcast($modPack);

        Event::assertDispatched(ModPackProcessDone::class);
        Event::assertNotDispatched(ModPackProcessStarted::class);
    }

    /**
     * @test
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function assert_modpacks_stated_must_be_triggered_when_files_to_process()
    {
        $modPack = Modpack::factory()->create();

        $this->downloadFiles($modPack);

        Event::fake([
            ModPackProcessStarted::class,
            ModPackProcessProgress::class,
            ModPackProcessDone::class
        ]);

        ModPackUpdateRequested::broadcast($modPack);

        Event::assertDispatched(ModPackProcessStarted::class);
        Event::assertDispatched(ModPackProcessProgress::class);
        Event::assertDispatched(ModPackProcessDone::class);
    }

    /**
     * @test
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function assert_modpacks_process_files_jobs_was_trigger()
    {
        $modPack = Modpack::factory()->create();

        $this->downloadFiles($modPack);

        Bus::fake([
            ProcessModPackFile::class
        ]);

        ModPackUpdateRequested::broadcast($modPack);

        Bus::assertBatched(function (PendingBatch $batch) use ($modPack) {
            return $batch->name === "Modpack update ($modPack->name - $modPack->id)" &&
                $batch->jobs->count() === 2;
        });
    }

    /**
     * @test
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function assert_modpack_manifest_info_was_correct()
    {
        $modPack = Modpack::factory()->create();

        $this->downloadFiles($modPack);

        $this->assertEquals(0, $modPack->manifest_info['size']);
        $this->assertEquals(0, $modPack->manifest_info['files']);

        ModPackUpdateRequested::broadcast($modPack);

        $modPack->refresh();

        $expectedFilesSizes = self::FILE_1MB_SIZE + self::FILE_10MB_SIZE;

        $this->assertEquals($expectedFilesSizes, $modPack->manifest_info['size']);
        $this->assertEquals(2, $modPack->manifest_info['files']);
    }

    /**
     * @test
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function assert_modpack_manifest_was_correct()
    {
        $modPack = Modpack::factory()->create();
        $this->assertEmpty($modPack->manifest);

        $this->downloadFiles($modPack);
        ModPackUpdateRequested::broadcast($modPack);

        $modPack->refresh();
        $manifest = collect($modPack->manifest);

        $this->assertCount(2, $manifest);

        $file1Mb = $manifest->get("{$modPack->name}/1Mb-dat");
        $this->assertEquals(self::FILE_1MB_SIZE, $file1Mb['size']);
        $this->assertEquals(self::FILE_1MB_SHA256, $file1Mb['sha256']);

        $file10Mb = $manifest->get("{$modPack->name}/10Mb-dat");
        $this->assertEquals(self::FILE_10MB_SIZE, $file10Mb['size']);
        $this->assertEquals(self::FILE_10MB_SHA256, $file10Mb['sha256']);
    }

    /**
     * UTILS PART
     *
     */

    /**
     * @param Modpack $modPack
     * @throws \Illuminate\Http\Client\RequestException
     */
    private function downloadFiles(Modpack $modPack)
    {

        // 1Mb file
        $fileContent = Http::get(self::FILE_1MB_URL)->throw()->body();
        Storage::disk($modPack->disk)->put("$modPack->path/1Mb.dat", $fileContent);

        // 10Mb file
        $fileContent = Http::get(self::FILE_10MB_URL)->throw()->body();
        Storage::disk($modPack->disk)->put("$modPack->path/10Mb.dat", $fileContent);
    }
}