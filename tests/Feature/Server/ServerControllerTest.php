<?php

namespace Tests\Feature\Server;

use App\Models\Game;
use App\Models\Modpack;
use App\Models\Server;
use App\Models\ServerStatus;
use Faker\Factory;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ServerControllerTest extends TestCase
{
    /**
     * @test
     */
    public function user_cannot_retrieve_servers_if_not_authenticated()
    {
        Server::factory(3)->create();

        $this->get('/api/servers')
            ->assertUnauthorized();
    }

    /**
     * @test
     */
    public function user_can_retrieve_servers()
    {
        $this->initUser();

        Server::factory(3)->create();

        $this->get('/api/servers')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [
                        'name',
                        'ip',
                        'port',
                        'game' => [
                            'name',
                            'identifier'
                        ],
                        'status'
                    ]
                ]
            ])->assertJsonCount(3, 'data');
    }

    /**
     * @test
     */
    public function user_can_retrieve_one_server_by_id()
    {
        $this->initUser();

        $server = Server::factory(3)->create()->first();

        $this->get("/api/servers/{$server->id}")
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $server->id,
                    'name' => $server->name,
                    'ip' => $server->ip,
                    'port' => $server->port,
                    'game' => [
                        'name' => $server->game->name,
                        'identifier' => $server->game->identifier,
                        'appid' => $server->game->appid,
                        'logo_url' => $server->game->logo_url,
                    ],
                    'status' => null,
                ]
            ]);
    }

    /**
     * @test
     */
    public function server_must_have_status()
    {
        $this->initUser();

        $server = Server::factory(3)->create()->first();

        $status = ServerStatus::factory()->createMany([
            [
                'server_id' => $server->id
            ],
            [
                'server_id' => $server->id,
                'created_at' => now()->addHour()
            ]
        ])->last();

        $this->get("/api/servers/{$server->id}")
            ->assertOk()
            ->assertJson([
                'data' => [
                    'status' => [
                        'online' => $status->online,
                        'players_max' => $status->players_max,
                        'players_online' => $status->players_online
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function an_unauthorized_user_can_not_manage_servers()
    {
        $this->initUser();

        $server = Server::factory()->create();

        // $this->get(route('servers.index'))
        //    ->assertForbidden();

        $this->get(route('servers.create'))
            ->assertForbidden();

        $this->post(route('servers.store'))
            ->assertForbidden();

        $this->get(route('servers.edit', $server))
            ->assertForbidden();

        $this->put(route('servers.update', $server))
            ->assertForbidden();

        $this->delete(route('servers.destroy.logo', $server))
            ->assertForbidden();

        $this->delete(route('servers.destroy', $server))
            ->assertForbidden();
    }

    /**
     * @test
     */
    public function an_authorized_user_can_create_a_server()
    {
        $faker = Factory::create();

        $this->initUser('owner');

        $modPacks = Modpack::factory()->count(2)->create();

        $game = Game::factory()->asArma3()->create();

        $name = $faker->unique()->name;

        $this->post(route('servers.store'), [
            'name' => $name,
            'modPacks' => $modPacks,
            'logo' => UploadedFile::fake()->image('logo.jpg'),
            'ip' => $faker->ipv4,
            'port' => $faker->randomNumber(6),
            'game' => $game->id,
        ])->assertStatus(302);

        $this->assertDatabaseHas('servers', [
            'name' => $name,
            'game_id' => $game->id,
        ]);
    }

    /**
     * @test
     */
    public function _can_edit_a_server()
    {
        $faker = Factory::create();

        $this->initUser('owner');

        $game = Game::factory()->asArma3()->create();

        $server = Server::factory()->create([
            'game_id' => $game->id
        ]);

        $this->assertEmpty($server->modpacks);

        $newName = $faker->unique()->name;
        $newModPacks = Modpack::factory()->count(2)->create()->map(fn ($mod) => $mod->id );
        $newLogo = UploadedFile::fake()->image('logo2.jpg');
        $newIp = $faker->ipv4;
        $newPort = $faker->randomNumber(6);

        $this->put(route('servers.update', $server), [
            'name' => $newName,
            'modPacks' => $newModPacks,
            'logo' => $newLogo,
            'ip' => $newIp,
            'port' => $newPort,
        ])->assertStatus(302);

        $this->assertDatabaseHas('servers', [
            'name' => $newName,
            'ip' => $newIp,
            'port' => $newPort,
        ]);
    }

    /**
     * @test
     */
    public function _can_delete_a_server() {
        $this->initUser('owner');

        $server = Server::factory()->create();

        $this->delete(route('servers.destroy', $server));

        $this->assertSoftDeleted($server);
    }
}
