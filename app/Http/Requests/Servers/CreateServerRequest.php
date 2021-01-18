<?php

namespace App\Http\Requests\Servers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateServerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('servers-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min: 3', 'max:80', 'unique:servers'],
            'logo' => ['nullable', 'file', 'image', 'max:8192'],
            'ip' => ['required', 'string', 'min:4'],
            'port' => ['required', 'integer', 'digits_between:2,6'],
            'game' => ['required', 'uuid', 'exists:games,id'],
            'modPack' => ['required', 'uuid', 'exists:modpacks,id'],
        ];
    }
}
