<?php

namespace App\Http\Requests\Servers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditServerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('servers-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $server = $this->route('server');
        return [
            'name' => ['required', 'string', 'min: 3', 'max:80', Rule::unique('servers')->ignore($server->id)],
            'logo' => ['nullable', 'file', 'image', 'max:8192'],
            'ip' => ['required', 'string', 'min:4'],
            'port' => ['required', 'integer', 'digits_between:2,6'],
            'modPacks.*' => ['nullable', 'uuid', 'exists:modpacks,id'],
        ];
    }
}
