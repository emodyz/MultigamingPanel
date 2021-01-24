<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class VoiceSettings extends Settings
{
    public ?string $type;

    public ?array $payload;

    public static function group(): string
    {
        return 'voice';
    }
}
