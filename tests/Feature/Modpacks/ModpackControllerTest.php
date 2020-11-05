<?php

namespace Tests\Feature\Modpacks;

use App\Events\Modpack\ModpackUpdateRequested;
use App\Models\Modpack;
use App\Models\Server;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ModpackControllerTest extends TestCase
{
    /**
     * @test
     */
    public function cannot_retrieve_modpacks_if_not_authenticated()
    {
        $this->get('/api/modpacks')
            ->assertUnauthorized();
    }

    /**
     * @test
     */
    public function can_retrieve_modpacks_when_authenticated()
    {
        $this->initUser();

        $this->get('/api/modpacks')
            ->assertOk();
    }

    /**
     * @test
     */
    public function assert_modpacks_structure()
    {
        $this->initUser();

        $modpacksCount = 3;
        $serversByModpacksCount = 2;
        $serversCount = $modpacksCount * $serversByModpacksCount;

        Modpack::factory($modpacksCount)
            ->hasAttached(
                Server::factory()->count($serversByModpacksCount)
            )->create();

        $this->get('/api/modpacks')
            ->assertOk()
            ->assertJsonCount($modpacksCount, 'data')
            ->assertJsonCount($serversCount, 'data.*.servers.*')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'batch',
                        'servers' => [
                            [
                                'id',
                                'name',
                                'ip',
                                'port',
                                'logo_url',
                                'status',
                                'game',
                                'update_hash'
                            ]
                        ],
                        'manifest',
                        'manifest_last_update'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function can_retrieve_modpack_by_id()
    {
        $this->initUser();

        $modpack = Modpack::factory(3)->create()->first();

        $this->get("/api/modpacks/{$modpack->id}")
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $modpack->id,
                    'name' => $modpack->name,
                    'batch' => $modpack->batch,
                    'servers' => $modpack->servers->toArray(),
                    'manifest' => $modpack->manifest,
                    'manifest_last_update' => $modpack->manifest_last_update
                ]
            ]);
    }

    /**
     * @test
     */
    public function assert_that_modpack_have_server_attached()
    {
        $this->initUser();

        $modpack = Modpack::factory(3)
            ->hasAttached(
                Server::factory()->count(2)
            )->create()->first();
        $servers = $modpack->servers;

        $modpackServersResponse = $this->get("/api/modpacks/{$modpack->id}")
            ->assertOk()
            ->assertJsonCount(2, 'data.servers')
            ->json('data.servers');

        $servers->each(function ($server, $index) use ($modpackServersResponse) {
            $currentServerModpack = $modpackServersResponse[$index];

            $this->assertEquals($server->id, $currentServerModpack['id']);
            $this->assertEquals($server->name, $currentServerModpack['name']);
            $this->assertEquals($server->game->name, $currentServerModpack['game']['name']);
        });
    }

    /**
     * @test
     */
    public function assert_can_create_modpacks()
    {
        $this->initUser();

        $disk = 'modpacks';

        $this->assertFalse(Storage::disk($disk)->exists('Bar'));

        $this->post("/api/modpacks", [
            'name' => '@Foo',
            'path' => 'Bar',
            'disk' => $disk
        ])->assertCreated();

        $this->assertTrue(Storage::disk($disk)->exists('Bar'));
    }

    /**
     * @test
     */
    public function assert_can_delete_modpack()
    {
        $this->initUser();

        $disk = 'modpacks';

        $modpack = Modpack::factory()->create([
            'disk' => $disk
        ]);

        $this->assertTrue(Storage::disk($disk)->exists($modpack->path));

        $this->delete("/api/modpacks/{$modpack->id}")
            ->assertNoContent();

        $this->assertFalse(Storage::disk($disk)->exists($modpack->path));
    }

    /**
     * @test
     */
    public function assert_cannot_delete_modpack_if_update_was_in_progress()
    {
        $this->initUser();

        $disk = 'modpacks';

        $batchId = Bus::batch([])->dispatch()->id;
        $modpack = Modpack::factory()->create([
            'disk' => $disk,
            'job_batch_id' => $batchId
        ]);

        $this->delete("/api/modpacks/{$modpack->id}")
            ->assertStatus(Response::HTTP_LOCKED);
    }

    /**
     * @test
     */
    public function assert_cannot_create_two_modpack_with_same_name()
    {
        $this->initUser();

        Modpack::factory()->create([
            'name' => 'Foo'
        ]);

        $this->post("/api/modpacks", [
            'name' => 'Foo'
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function assert_cannot_create_two_modpack_with_same_local_path()
    {
        $this->initUser();

        Modpack::factory()->create([
            'path' => 'Bar'
        ]);

        $this->post("/api/modpacks", [
            'name' => 'Toto',
            'path' => 'Bar'
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function wrong_disk_must_throw_exception()
    {
        $this->initUser();

        $this->post("/api/modpacks", [
            'name' => 'Foo',
            'disk' => 'Bar'
        ])
            ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->assertSeeText('ModpackException');
    }

    /**
     * @test
     */
    public function start_update_of_modpack_should_trigger_event()
    {
        Event::fake([
            ModpackUpdateRequested::class
        ]);

        $this->initUser();

        $disk = 'modpacks';
        $modpack = Modpack::factory()->create([
            'disk' => $disk
        ]);

        $this->post(route('modpacks.update.start', $modpack->id))
            ->assertCreated();

        Event::assertDispatched(ModpackUpdateRequested::class, 1);
    }

    /**
     * @test
     */
    public function assert_cannot_start_modpack_update_since_another_update_in_progress()
    {
        $this->initUser();

        $disk = 'modpacks';

        $batchId = Bus::batch([])->dispatch()->id;
        $modpack = Modpack::factory()->create([
            'disk' => $disk,
            'job_batch_id' => $batchId
        ]);

        $this->post(route('modpacks.update.start', $modpack->id))
            ->assertStatus(Response::HTTP_LOCKED);
    }

    /**
     * @test
     */
    public function assert_can_cancel_modpack_update()
    {
        $this->initUser();

        $disk = 'modpacks';

        $batchId = Bus::batch([])->dispatch()->id;
        $modpack = Modpack::factory()->create([
            'disk' => $disk,
            'job_batch_id' => $batchId
        ]);

        $this->delete(route('modpacks.update.cancel', $modpack->id))
            ->assertNoContent();
    }

    /**
     * @test
     */
    public function assert_that_cannot_cancel_modpack_update_when_no_update_in_progress()
    {
        $this->initUser();

        $disk = 'modpacks';

        $modpack = Modpack::factory()->create([
            'disk' => $disk
        ]);

        $this->delete(route('modpacks.update.cancel', $modpack->id))
            ->assertStatus(Response::HTTP_CONTINUE);
    }
}