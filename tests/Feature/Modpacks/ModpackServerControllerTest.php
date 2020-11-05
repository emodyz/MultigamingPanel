<?php

namespace Tests\Feature\Modpacks;

use App\Models\Modpack;
use App\Models\Server;
use Illuminate\Http\Response;
use Tests\TestCase;

class ModpackServerControllerTest extends TestCase
{
    /**
     * @test
     */
    public function cannot_attach_if_unauthenticated()
    {
        $server = Server::factory()->create();
        $modpack = Modpack::factory()->create();

        $this->post("/api/modpacks/{$modpack->id}/servers/{$server->id}")
            ->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_detach_if_unauthenticated()
    {
        $server = Server::factory()->create();
        $modpack = Modpack::factory()->create();

        $this->delete("/api/modpacks/{$modpack->id}/servers/{$server->id}")
            ->assertUnauthorized();
    }


    /**
     * @test
     */
    public function can_attach_modpack_to_server()
    {
        $this->initUser();

        $server = Server::factory()->create();
        $modpack = Modpack::factory()->create();

        $this->assertCount(0, $server->modpacks);
        $this->assertCount(0, $modpack->servers);

        $this->post("/api/modpacks/{$modpack->id}/servers/{$server->id}")
            ->assertNoContent();

        $modpack->refresh();
        $server->refresh();

        $this->assertCount(1, $server->modpacks);
        $this->assertCount(1, $modpack->servers);

        $this->assertEquals($server->id, $modpack->servers->first()->id);
        $this->assertEquals($modpack->id, $server->modpacks->first()->id);
    }

    /**
     * @test
     */
    public function can_detach_modpack_to_server()
    {
        $this->initUser();

        $server = Server::factory()->create();
        $modpack = Modpack::factory()->create();

        $server->modpacks()->attach($modpack);

        $this->assertCount(1, $server->modpacks);
        $this->assertCount(1, $modpack->servers);

        $this->delete("/api/modpacks/{$modpack->id}/servers/{$server->id}")
            ->assertNoContent();

        $modpack->refresh();
        $server->refresh();

        $this->assertCount(0, $server->modpacks);
        $this->assertCount(0, $modpack->servers);
    }

    /**
     * @test
     */
    public function cannot_attach_if_already_attached()
    {
        $this->initUser();

        $server = Server::factory()->create();
        $modpack = Modpack::factory()->create();

        $server->modpacks()->attach($modpack);

        $this->post("/api/modpacks/{$modpack->id}/servers/{$server->id}")
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function cannot_detach_if_not_attached()
    {
        $this->initUser();

        $server = Server::factory()->create();
        $modpack = Modpack::factory()->create();

        $this->delete("/api/modpacks/{$modpack->id}/servers/{$server->id}")
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
