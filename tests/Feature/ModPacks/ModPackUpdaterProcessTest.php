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

    const FILE_1MIO_URL = 'http://www.ovh.net/files/1Mio.dat';
    const FILE_1MIO_SHA256 = '86f5cb58e26192af3f896704a4f974601ef04028a2f4da3e47b6c56d48e2fdba';
    const FILE_1MIO_SIZE = 1048576;

    const FILE_10MIO_URL = 'http://www.ovh.net/files/10Mio.dat';
    const FILE_10MIO_SHA256 = '784fb3de5ea02e70738cc3764f7bebf071376f364907d20c50822013c5b64e94';
    const FILE_10MIO_SIZE = 10485760;

    /**
     * @test
     */
    public function assert_that_modpack_update_request_start_modpack_update()
    {
        $modpack = Modpack::factory()->create();

        $spy = $this->spy(StartModPackUpdate::class);

        ModPackUpdateRequested::broadcast($modpack);

        $spy->shouldHaveReceived('handle');
    }

    /**
     * @test
     */
    public function assert_modpacks_update_without_files_must_be_done()
    {
        $modpack = Modpack::factory()->create();

        Event::fake([
            ModPackProcessDone::class,
            ModPackProcessStarted::class
        ]);

        ModPackUpdateRequested::broadcast($modpack);

        Event::assertDispatched(ModPackProcessDone::class);
        Event::assertNotDispatched(ModPackProcessStarted::class);
    }

    /**
     * @test
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function assert_modpacks_stated_must_be_triggered_when_files_to_process()
    {
        $modpack = Modpack::factory()->create();

        $this->downloadFiles($modpack);

        Event::fake([
            ModPackProcessStarted::class,
            ModPackProcessProgress::class,
            ModPackProcessDone::class
        ]);

        ModPackUpdateRequested::broadcast($modpack);

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
        $modpack = Modpack::factory()->create();

        $this->downloadFiles($modpack);

        Bus::fake([
            ProcessModPackFile::class
        ]);

        ModPackUpdateRequested::broadcast($modpack);

        Bus::assertBatched(function (PendingBatch $batch) use ($modpack) {
            return $batch->name === "Modpack update ($modpack->name - $modpack->id)" &&
                $batch->jobs->count() === 2;
        });
    }

    /**
     * @test
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function assert_modpack_manifest_info_was_correct()
    {
        $modpack = Modpack::factory()->create();

        $this->downloadFiles($modpack);

        $this->assertEquals(0, $modpack->manifest_info['size']);
        $this->assertEquals(0, $modpack->manifest_info['files']);

        ModPackUpdateRequested::broadcast($modpack);

        $modpack->refresh();

        $expectedFilesSizes = self::FILE_1MIO_SIZE + self::FILE_10MIO_SIZE;

        $this->assertEquals($expectedFilesSizes, $modpack->manifest_info['size']);
        $this->assertEquals(2, $modpack->manifest_info['files']);
    }

    /**
     * @test
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function assert_modpack_manifest_was_correct()
    {
        $modpack = Modpack::factory()->create();
        $this->assertEmpty($modpack->manifest);

        $this->downloadFiles($modpack);
        ModPackUpdateRequested::broadcast($modpack);

        $modpack->refresh();
        $manifest = collect($modpack->manifest);

        $this->assertCount(2, $manifest);

        $file1Mio = $manifest->get("{$modpack->name}/1Mio-dat");
        $this->assertEquals(self::FILE_1MIO_SIZE, $file1Mio['size']);
        $this->assertEquals(self::FILE_1MIO_SHA256, $file1Mio['sha256']);

        $file10Mio = $manifest->get("{$modpack->name}/10Mio-dat");
        $this->assertEquals(self::FILE_10MIO_SIZE, $file10Mio['size']);
        $this->assertEquals(self::FILE_10MIO_SHA256, $file10Mio['sha256']);
    }

    /**
     * UTILS PART
     *
     */

    /**
     * @param Modpack $modpack
     * @throws \Illuminate\Http\Client\RequestException
     */
    private function downloadFiles(Modpack $modpack)
    {

        // 1Mio file
        $fileContent = Http::get(self::FILE_1MIO_URL)->throw()->body();
        Storage::disk($modpack->disk)->put("$modpack->path/1Mio.dat", $fileContent);

        // 10Mio file
        $fileContent = Http::get(self::FILE_10MIO_URL)->throw()->body();
        Storage::disk($modpack->disk)->put("$modpack->path/10Mio.dat", $fileContent);
    }
}