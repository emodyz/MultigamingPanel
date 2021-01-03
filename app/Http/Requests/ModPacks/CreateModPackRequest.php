<?php

namespace App\Http\Requests\ModPacks;

use Illuminate\Foundation\Http\FormRequest;

class CreateModPackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      return $this->user()->can('modpack-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:modpacks,name'],
            'game' => ['required', 'exists:games,id'],

            'servers' => ['array'],
            'servers.*' => ['exists:servers,id'],

            'path' => ['nullable', 'unique:modpacks,path'],
            'disk' => ['nullable']
        ];
    }
}
