<?php

namespace Tests\Feature;

use App\Models\Server;
use App\Models\ServerStatus;
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
}
