<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditVoiceSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('settings-edit-voice');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => [
                'nullable',
                Rule::in($this->availableVoices())
            ],
            'payload' => 'array'
        ];
    }

    /**
     * Available voice providers
     */
    public function availableVoices(): array
    {
        return [
            'discord',
            'teamspeak3'
        ];
    }
}
