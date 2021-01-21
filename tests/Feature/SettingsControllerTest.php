<?php

namespace Tests\Feature;

use App\Settings\VoiceSettings;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class SettingsControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function assert_that_edit_settings_page_exist()
    {
        $this->initUser('owner');

        $this->get(route('settings.edit'))
          ->assertOk();
    }

    /**
     * @test
     */
    public function assert_that_permission_was_required_to_have_access_of_settings_page()
    {
        $this->initUser();

        $this->get(route('settings.edit'))
          ->assertForbidden();
    }

    /**
     * @test
     */
    public function assert_that_we_can_update_voices_settings()
    {
        $this->initUser('owner');

        $voiceSettings = app(VoiceSettings::class);

        $this->assertEquals(null, $voiceSettings->type);
        $this->assertEquals(null, $voiceSettings->payload);

        $fakedPayload =  [
          'serverId' => $this->faker->uuid
        ];

        $this->put(route('settings.update.voice'), [
          'type' => 'discord',
          'payload' => $fakedPayload
        ])->assertRedirect();

        $this->assertEquals('discord', $voiceSettings->type);
        $this->assertEquals($fakedPayload, $voiceSettings->payload);
    }

    /**
     * @test
     */
    public function assert_that_permission_was_required_to_update_voice_settings()
    {
        $this->initUser();

        $this->put(route('settings.update.voice'), [
          'type' => 'discord',
          'payload' => []
        ])->assertForbidden();
    }

    /**
     * @test
     */
    public function assert_wrong_voice_type_failed()
    {
        $this->initUser('owner');

        $this->put(route('settings.update.voice'), [
          'type' => 'wrongVoiceType',
          'payload' => []
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function assert_that_voice_settings_api_route_return_json()
    {
        $this->initUser('owner');

        $voiceSettings = VoiceSettings::fake([
            'type' => $this->faker->name,
            'payload' => $this->faker->rgbColorAsArray
        ]);

        $this->get(route('api.settings.show.voice'), [
          'type' => 'wrongVoiceType',
          'payload' => []
        ])->assertOk()
          ->assertJson([
            'type' => $voiceSettings->type,
            'payload' => $voiceSettings->payload,
          ]);
    }
}
