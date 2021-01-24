<?php


namespace App\Actions\Emodyz\Settings;


use App\Settings\VoiceSettings;
use Illuminate\Support\Arr;

class EditSettings
{
    /**
     * @var VoiceSettings
     */
    private VoiceSettings $voiceSettings;

    /**
     * EditSettings constructor.
     *
     * @param  VoiceSettings  $voiceSettings
     */
    public function __construct(VoiceSettings $voiceSettings)
    {
        $this->voiceSettings = $voiceSettings;
    }


    /**
     * Edit the voice settings
     *
     * @param  array  $input
     */
    public function editVoiceSettings(array $input)
    {
        $this->voiceSettings->type = Arr::get($input, 'type');
        $this->voiceSettings->payload = Arr::get($input, 'payload');

        $this->voiceSettings->save();
    }

}
