<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateVoiceSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup('voice', function (SettingsBlueprint $blueprint) {
            $blueprint->add('type', null);
            $blueprint->add('payload', null);
        });
    }
}
